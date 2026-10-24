<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Uploader;

/**
 * Serves files uploaded through the admin area from private storage.
 */
final class UploadController extends Controller
{
    public function show(string $file): void
    {
        if (!preg_match('/^[a-f0-9]{32}\.([a-z0-9]{2,5})$/', $file, $m)) {
            $this->fail(404, 'File not found.', 'site');
        }
        $mime = Uploader::mimeFor($m[1]);
        $path = App::config('app.uploads') . '/' . $file;
        if ($mime === null || !is_file($path)) {
            $this->fail(404, 'File not found.', 'site');
        }

        $isImage = str_starts_with($mime, 'image/');
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . (string)filesize($path));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: public, max-age=604800');
        if ($isImage) {
            header('Content-Disposition: inline');
        } else {
            // Downloads keep the name they were uploaded with.
            $name = Database::instance()->scalar(
                'SELECT file_name FROM resources WHERE file_path = ? LIMIT 1',
                ['uploads/' . $file]
            ) ?: $file;
            header('Content-Disposition: attachment; filename="' . str_replace(['"', "\r", "\n"], '', (string)$name) . '"');
        }
        readfile($path);
    }
}
