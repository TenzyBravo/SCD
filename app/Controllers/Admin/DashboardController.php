<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Models\AuditLog;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $db = Database::instance();
        $count = static fn(string $sql): int => (int)$db->scalar($sql);

        $tiles = [];
        if (can('news.manage')) {
            $tiles[] = ['Stories', 'news', $count("SELECT COUNT(*) FROM posts WHERE deleted_at IS NULL AND status = 'published'"),
                        $count("SELECT COUNT(*) FROM posts WHERE deleted_at IS NULL AND status = 'draft'")];
        }
        if (can('toolkits.manage')) {
            $tiles[] = ['Toolkits', 'toolkits', $count("SELECT COUNT(*) FROM resources WHERE deleted_at IS NULL AND status = 'published'"),
                        $count("SELECT COUNT(*) FROM resources WHERE deleted_at IS NULL AND status = 'draft'")];
        }
        if (can('jobs.manage')) {
            $tiles[] = ['Open vacancies', 'jobs', $count("SELECT COUNT(*) FROM jobs WHERE deleted_at IS NULL AND status = 'published' AND (deadline IS NULL OR deadline >= CURDATE())"),
                        $count("SELECT COUNT(*) FROM jobs WHERE deleted_at IS NULL AND status = 'draft'")];
        }
        if (can('training.manage')) {
            $tiles[] = ['Courses', 'training', $count("SELECT COUNT(*) FROM courses WHERE deleted_at IS NULL AND status = 'published'"),
                        $count("SELECT COUNT(*) FROM courses WHERE deleted_at IS NULL AND status = 'draft'")];
        }
        if (can('team.manage')) {
            $tiles[] = ['Leadership team', 'team', $count("SELECT COUNT(*) FROM team_members WHERE deleted_at IS NULL AND status = 'published'"),
                        $count("SELECT COUNT(*) FROM team_members WHERE deleted_at IS NULL AND status = 'draft'")];
        }

        $this->view('admin/dashboard', [
            'tiles'    => $tiles,
            'activity' => can('audit.view') ? (new AuditLog())->recent(8) : [],
        ], 'admin');
    }
}
