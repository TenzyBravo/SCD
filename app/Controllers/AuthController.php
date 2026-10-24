<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Audit;
use App\Core\Auth;
use App\Core\Controller;
use App\Core\Flash;
use App\Core\Request;
use App\Core\Validator;
use App\Models\Role;
use App\Models\User;

final class AuthController extends Controller
{
    // ------------------------------------------------------------ first run
    /** Creating the first administrator is only possible while no account exists. */
    private function setupAllowed(): bool
    {
        return (new User())->total() === 0;
    }

    public function setupForm(): void
    {
        if (!$this->setupAllowed()) {
            $this->redirect('admin/login');
        }
        $this->view('auth/setup', [], 'auth');
    }

    public function setup(): void
    {
        if (!$this->setupAllowed()) {
            $this->redirect('admin/login');
        }
        $data = $this->validate([
            'name'                  => 'required|max:120',
            'email'                 => 'required|email|max:190',
            'password'              => 'required|password',
            'password_confirmation' => 'required|match:password',
        ], ['password_confirmation' => 'Password confirmation'], 'admin/setup');

        $admin = (new Role())->findBySlug('admin');
        if ($admin === null) {
            $this->fail(500, 'The roles are missing. Import database/seed.sql first.', 'auth');
        }
        $id = (new User())->createUser($data['name'], $data['email'], $data['password'], (int)$admin['id'], false);
        Audit::log('setup.admin_created', 'user', $id, 'First administrator created');

        Auth::attempt($data['email'], $data['password']);
        Flash::success('Your administrator account is ready.');
        $this->redirect('admin');
    }

    // ------------------------------------------------------------ sign in/out
    public function loginForm(): void
    {
        if ($this->setupAllowed()) {
            $this->redirect('admin/setup');
        }
        $this->view('auth/login', [], 'auth');
    }

    public function login(): void
    {
        $this->validate(['email' => 'required|email', 'password' => 'required'], [], 'admin/login');
        $result = Auth::attempt((string)Request::input('email'), (string)($_POST['password'] ?? ''));
        if (!$result['ok']) {
            Flash::withErrors([], ['email' => Request::input('email')]);
            Flash::error($result['message']);
            $this->redirect('admin/login');
        }
        Flash::success($result['message']);
        $this->redirect(Auth::mustChangePassword() ? 'admin/password' : 'admin');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('admin/login');
    }

    // ------------------------------------------------------------ own password
    public function passwordForm(): void
    {
        $this->view('auth/password', ['forced' => Auth::mustChangePassword()], 'admin');
    }

    public function password(): void
    {
        $data = $this->validate([
            'current_password'      => 'required',
            'password'              => 'required|password',
            'password_confirmation' => 'required|match:password',
        ], ['password' => 'New password', 'password_confirmation' => 'Password confirmation'], 'admin/password');

        $user = Auth::user();
        $v    = new Validator([]);
        if (!password_verify($data['current_password'], (string)$user['password_hash'])) {
            $v->add('current_password', 'Your current password is incorrect.');
        } elseif (hash_equals($data['current_password'], $data['password'])) {
            $v->add('password', 'The new password must be different from the current one.');
        }
        if ($v->fails()) {
            Flash::withErrors($v->errors());
            Flash::error((string)$v->firstError());
            $this->redirect('admin/password');
        }

        (new User())->setPassword((int)$user['id'], $data['password']);
        Audit::log('password.changed', 'user', (int)$user['id'], 'Changed own password');
        Flash::success('Your password has been changed.');
        $this->redirect('admin');
    }
}
