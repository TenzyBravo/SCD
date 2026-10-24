<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\AuditLog;
use App\Models\User;

final class AuditController extends Controller
{
    public function index(): void
    {
        $log     = new AuditLog();
        $filters = ['user_id' => Request::int('user_id'), 'action' => (string)Request::input('action', '')];
        $page    = $this->paginate($log->countFiltered($filters), 30);

        $this->view('admin/audit', [
            'entries' => $log->page($filters, $page['perPage'], $page['offset']),
            'page'    => $page,
            'filters' => $filters,
            'users'   => (new User())->listWithRoles(),
            'actions' => $log->actions(),
        ], 'admin');
    }
}
