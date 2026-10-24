<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Audit;
use App\Core\Controller;
use App\Core\Flash;
use App\Models\Role;

final class RolesController extends Controller
{
    public function index(): void
    {
        $roles = new Role();
        $this->view('admin/roles', [
            'roles'       => $roles->listWithCounts(),
            'permissions' => $roles->permissions(),
            'matrix'      => $roles->matrix(),
        ], 'admin');
    }

    public function update(): void
    {
        $roles   = new Role();
        $valid   = array_map('intval', array_column($roles->permissions(), 'id'));
        $posted  = is_array($_POST['perm'] ?? null) ? $_POST['perm'] : [];
        $before  = $roles->matrix();
        $changed = [];

        foreach ($roles->listWithCounts() as $role) {
            // The administrator role always keeps every permission, so nobody can lock themselves out.
            if ($role['slug'] === 'admin') {
                continue;
            }
            $rid    = (int)$role['id'];
            $chosen = array_values(array_intersect($valid, array_map('intval', (array)($posted[$rid] ?? []))));
            sort($chosen);
            $had = array_keys($before[$rid] ?? []);
            sort($had);
            if ($chosen !== $had) {
                $roles->syncPermissions($rid, $chosen);
                $changed[] = $role['name'];
                Audit::log('role.permissions', 'role', $rid, 'Changed permissions of ' . $role['name'],
                    ['permission_ids' => $had], ['permission_ids' => $chosen]);
            }
        }

        Flash::success($changed === [] ? 'No changes to save.' : 'Permissions updated for ' . implode(', ', $changed) . '.');
        $this->redirect('admin/roles');
    }
}
