<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\App;

final class User extends Model
{
    protected string $table = 'users';
    protected bool $softDeletes = false;

    public function findByEmail(string $email): ?array
    {
        return $this->db()->one('SELECT * FROM users WHERE email = ?', [mb_strtolower(trim($email))]);
    }

    public function findWithRole(int $id): ?array
    {
        return $this->db()->one(
            'SELECT u.*, r.slug AS role_slug, r.name AS role_name
               FROM users u JOIN roles r ON r.id = u.role_id
              WHERE u.id = ?',
            [$id]
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function listWithRoles(): array
    {
        return $this->db()->all(
            'SELECT u.*, r.name AS role_name, r.slug AS role_slug
               FROM users u JOIN roles r ON r.id = u.role_id
              ORDER BY u.status ASC, u.name ASC'
        );
    }

    /** @return array<int,string> */
    public function permissionsForRole(int $roleId): array
    {
        return array_column($this->db()->all(
            'SELECT p.slug FROM role_permissions rp JOIN permissions p ON p.id = rp.permission_id
              WHERE rp.role_id = ?',
            [$roleId]
        ), 'slug');
    }

    public function createUser(string $name, string $email, string $password, int $roleId, bool $mustChange): int
    {
        return $this->create([
            'name'                 => $name,
            'email'                => mb_strtolower(trim($email)),
            'password_hash'        => password_hash($password, PASSWORD_DEFAULT),
            'role_id'              => $roleId,
            'must_change_password' => $mustChange ? 1 : 0,
        ]);
    }

    public function setPassword(int $id, string $password, bool $mustChange = false): void
    {
        $this->updateById($id, [
            'password_hash'        => password_hash($password, PASSWORD_DEFAULT),
            'must_change_password' => $mustChange ? 1 : 0,
            'failed_attempts'      => 0,
            'locked_until'         => null,
        ]);
    }

    public function registerFailedAttempt(int $id): void
    {
        $max     = (int)App::config('security.max_login_attempts', 5);
        $minutes = (int)App::config('security.lockout_minutes', 15);
        $this->db()->run(
            'UPDATE users
                SET locked_until    = IF(failed_attempts + 1 >= :max1, DATE_ADD(NOW(), INTERVAL :mins MINUTE), locked_until),
                    failed_attempts = IF(failed_attempts + 1 >= :max2, 0, failed_attempts + 1)
              WHERE id = :id',
            ['max1' => $max, 'max2' => $max, 'mins' => $minutes, 'id' => $id]
        );
    }

    public function recordLogin(int $id): void
    {
        $this->db()->run(
            'UPDATE users SET failed_attempts = 0, locked_until = NULL, last_login_at = NOW() WHERE id = ?',
            [$id]
        );
    }

    /** Active administrators — used to stop the last one being demoted or suspended. */
    public function activeAdminCount(): int
    {
        return (int)$this->db()->scalar(
            "SELECT COUNT(*) FROM users u JOIN roles r ON r.id = u.role_id
              WHERE r.slug = 'admin' AND u.status = 'active'"
        );
    }

    public function total(): int
    {
        return (int)$this->db()->scalar('SELECT COUNT(*) FROM users');
    }
}
