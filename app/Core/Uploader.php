<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Upload handler for images and downloadable documents.
 *
 * Files are stored in storage/uploads (denied to direct HTTP access) under
 * random names and served back through UploadController, so an uploaded file
 * can never be executed by the web server.
 */
final class Uploader
{
    private const TYPES = [
        'image' => [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ],
        'document' => [
            'application/pdf'    => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/zip' => 'zip',
        ],
    ];

    /** Extension → MIME type for every type the uploader can store. */
    public static function mimeFor(string $ext): ?string
    {
        foreach (self::TYPES as $types) {
            $found = array_search($ext, $types, true);
            if ($found !== false) {
                return $found;
            }
        }
        return null;
    }

    /**
     * Store one uploaded file.
     *
     * @param 'image'|'document' $kind
     * @return array{path:?string,name:?string,size:int,mime:?string,error:?string}
     *         path is null with error null when no file was chosen.
     */
    public static function handle(string $inputName, string $kind): array
    {
        $none = ['path' => null, 'name' => null, 'size' => 0, 'mime' => null, 'error' => null];
        $file = $_FILES[$inputName] ?? null;
        if (!is_array($file) || is_array($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $none;
        }

        $fail = static fn(string $msg): array => ['error' => $msg] + $none;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return $fail(self::errorText((int)$file['error']));
        }
        $maxBytes = (int)App::config('uploads.max_bytes', 20 * 1024 * 1024);
        if ($file['size'] <= 0 || $file['size'] > $maxBytes) {
            return $fail(sprintf('The file exceeds the %d MB limit.', intdiv($maxBytes, 1048576)));
        }
        if (!is_uploaded_file($file['tmp_name'])) {
            return $fail('The file could not be verified as an upload.');
        }

        // Trust the sniffed type, never the client-supplied one.
        $mime    = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) ?: '';
        $allowed = self::TYPES[$kind] ?? [];
        if (!isset($allowed[$mime])) {
            $what = $kind === 'image' ? 'JPG, PNG, WebP or GIF' : 'PDF, Word, Excel, PowerPoint or ZIP';
            return $fail("Unsupported file type ({$mime}). Upload a {$what} file.");
        }

        $dir = (string)App::config('app.uploads');
        if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
            return $fail('The upload directory is not writable.');
        }

        $name = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
            return $fail('The file could not be saved.');
        }
        @chmod($dir . '/' . $name, 0644);

        return [
            'path'  => 'uploads/' . $name,
            'name'  => mb_substr(self::sanitiseName((string)$file['name']), 0, 255),
            'size'  => (int)$file['size'],
            'mime'  => $mime,
            'error' => null,
        ];
    }

    private static function sanitiseName(string $name): string
    {
        $name = preg_replace('/[^\w .\-()]+/u', '_', basename($name)) ?? 'file';
        return trim($name) === '' ? 'file' : $name;
    }

    private static function errorText(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The file is too large.',
            UPLOAD_ERR_PARTIAL    => 'The upload was interrupted.',
            UPLOAD_ERR_NO_TMP_DIR => 'The server temporary directory is missing.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not write the file.',
            default               => 'The upload failed.',
        };
    }
}
