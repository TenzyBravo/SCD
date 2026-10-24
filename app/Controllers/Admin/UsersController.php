<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Audit;
use App\Core\Auth;
use App\Core\Controller;
use App\Core\Flash;
use App\Core\Validator;
use App\Models\Role;
use App\Models\User;

final class UsersController extends Controller
{
    private const LABELS = ['role_id' => 'Role', 'password' => 'Temporary password'];

    public function index(): void
    {
        $this->view('admin/users/index', ['users' => (new User())->listWithRoles()], 'admin');
    }

    public function create(): void
    {
        $this->view('admin/users/form', ['user' => null, 'roles' => (new Role())->allRows()], 'admin');
    }

    public function store(): void
    {
        $data = $this->validate([
            'name'     => 'required|max:120',
            'email'    => 'required|email|max:190|unique:users,email',
            'role_id'  => 'required|int|exists:roles,id',
            'password' => 'required|password',
        ], self::LABELS, 'admin/users/new');

        // Staff must replace the temporary password the first time they sign in.
        $id = (new User())->createUser($data['name'], $data['email'], $data['password'], (int)$data['role_id'], true);
        Audit::log('user.created', 'user', $id, 'Created account for ' . $data['email'], null,
            ['name' => $data['name'], 'email' => $data['email'], 'role_id' => (int)$data['role_id']]);
        Flash::success("Account created for {$data['name']}. Give them the temporary password; they will be asked to change it.");
        $this->redirect('admin/users');
    }

    public function edit(string $id): void
    {
        $this->view('admin/users/form', ['user' => $this->findOrFail($id), 'roles' => (new Role())->allRows()], 'admin');
    }

    public function update(string $id): void
    {
        $users = new User();
        $user  = $this->findOrFail($id);
        $back  = "admin/users/{$user['id']}/edit";
        $data  = $this->validate([
            'name'     => 'required|max:120',
            'email'    => 'required|email|max:190|unique:users,email,' . $user['id'],
            'role_id'  => 'required|int|exists:roles,id',
            'status'   => 'required|in:active,suspended',
            'password' => 'nullable|password',
        ], self::LABELS, $back);

        // Never leave the site without an active administrator.
        $wasAdmin  = $user['role_slug'] === 'admin' && $user['status'] === 'active';
        $newRole   = (new Role())->find((int)$data['role_id']);
        $staysAdmin = ($newRole['slug'] ?? '') === 'admin' && $data['status'] === 'active';
        if ($wasAdmin && !$staysAdmin && $users->activeAdminCount() <= 1) {
            $this->bounce('role_id', 'This is the only active administrator. Make someone else an administrator first.', $back);
        }
        if ((int)$user['id'] === Auth::id() && $data['status'] !== 'active') {
            $this->bounce('status', 'You cannot suspend your own account.', $back);
        }

        $changes = [
            'name'    => $data['name'],
            'email'   => mb_strtolower($data['email']),
            'role_id' => (int)$data['role_id'],
            'status'  => $data['status'],
        ];
        $users->updateById((int)$user['id'], $changes);
        if ($data['password'] !== '') {
            $users->setPassword((int)$user['id'], $data['password'], true);
        }

        $old = $new = [];
        foreach ($changes as $key => $value) {
            if ((string)$user[$key] !== (string)$value) {
                $old[$key] = $user[$key];
                $new[$key] = $value;
            }
        }
        if ($data['password'] !== '') {
            $new['password'] = 'reset';
        }
        Audit::log('user.updated', 'user', (int)$user['id'], 'Updated account for ' . $changes['email'], $old, $new);
        Flash::success('Account saved.' . ($data['password'] !== '' ? ' They will be asked to change the new temporary password when they sign in.' : ''));
        $this->redirect('admin/users');
    }

    private function findOrFail(string $id): array
    {
        $user = ctype_digit($id) ? (new User())->findWithRole((int)$id) : null;
        if ($user === null) {
            $this->fail(404, 'That account does not exist.');
        }
        return $user;
    }

    private function bounce(string $field, string $message, string $back): never
    {
        $old = $_POST;
        unset($old['password'], $old['_token']);
        $v = new Validator([]);
        $v->add($field, $message);
        Flash::withErrors($v->errors(), $old);
        Flash::error($message);
        $this->redirect($back);
    }
}
