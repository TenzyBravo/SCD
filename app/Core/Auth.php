<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\User;

/**
 * Staff authentication + role/permission resolution.
 */
final class Auth
{
    private static ?array $user = null;
    private static ?array $permissions = null;

    public static function attempt(string $email, string $password): array
    {
        $users = new User();
        $user  = $users->findByEmail($email);

        // Uniform failure response — never reveals whether the account exists.
        $generic = ['ok' => false, 'message' => 'Invalid email address or password.'];

        if ($user === null) {
            Audit::log('login.failed', null, null, 'Unknown email: ' . mb_substr($email, 0, 190));
            // Equalise timing against the hash comparison below.
            password_verify($password, '$2y$10$invalidinvalidinvalidinvalidinvalidinvalidinvalidinvalidinv');
            return $generic;
        }

        if ($user['locked_until'] !== null && strtotime((string)$user['locked_until']) > time()) {
            $minutes = (int)ceil((strtotime((string)$user['locked_until']) - time()) / 60);
            return ['ok' => false, 'message' => "Too many failed attempts. Try again in {$minutes} minute(s)."];
        }

        if (!password_verify($password, $user['password_hash'])) {
            $users->registerFailedAttempt((int)$user['id']);
            Audit::log('login.failed', 'user', (int)$user['id'], 'Wrong password');
            return $generic;
        }

        if ($user['status'] !== 'active') {
            return ['ok' => false, 'message' => 'This account has been suspended. Contact the administrator.'];
        }

        // Success.
        $users->recordLogin((int)$user['id']);
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $users->setPassword((int)$user['id'], $password, (bool)$user['must_change_password']);
        }
        session_regenerate_id(true);
        Session::set('user_id', (int)$user['id']);
        Session::set('_rotated', time());
        self::$user = null;
        self::$permissions = null;

        Audit::log('login.success', 'user', (int)$user['id'], 'Signed in');

        return ['ok' => true, 'message' => 'Welcome back, ' . $user['name'] . '.'];
    }

    public static function logout(): void
    {
        $id = self::id();
        if ($id !== null) {
            Audit::log('logout', 'user', $id, 'Signed out');
        }
        Session::destroy();
        self::$user = null;
        self::$permissions = null;
    }

    public static function id(): ?int
    {
        $id = $_SESSION['user_id'] ?? null;
        return is_int($id) ? $id : (is_numeric($id) ? (int)$id : null);
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function user(): ?array
    {
        if (self::$user !== null) {
            return self::$user;
        }
        $id = self::id();
        if ($id === null) {
            return null;
        }
        $user = (new User())->findWithRole($id);
        if ($user === null || $user['status'] !== 'active') {
            Session::forget('user_id');
            return null;
        }
        return self::$user = $user;
    }

    public static function name(): string
    {
        return self::user()['name'] ?? 'Guest';
    }

    public static function roleName(): string
    {
        return self::user()['role_name'] ?? '';
    }

    public static function mustChangePassword(): bool
    {
        return (bool)(self::user()['must_change_password'] ?? false);
    }

    /** @return array<int,string> permission slugs */
    public static function permissions(): array
    {
        if (self::$permissions !== null) {
            return self::$permissions;
        }
        $user = self::user();
        return self::$permissions = $user === null ? [] : (new User())->permissionsForRole((int)$user['role_id']);
    }

    public static function can(string $permission): bool
    {
        return in_array($permission, self::permissions(), true);
    }
}
