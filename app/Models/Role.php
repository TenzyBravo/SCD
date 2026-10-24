<?php
declare(strict_types=1);

namespace App\Models;

final class Role extends Model
{
    protected string $table = 'roles';
    protected bool $softDeletes = false;

    /** @return array<int,array<string,mixed>> roles with their user counts */
    public function listWithCounts(): array
    {
        return $this->db()->all(
            'SELECT r.*, (SELECT COUNT(*) FROM users u WHERE u.role_id = r.id) AS user_count
               FROM roles r ORDER BY r.id ASC'
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function permissions(): array
    {
        return $this->db()->all('SELECT * FROM permissions ORDER BY sort_order ASC, id ASC');
    }

    /** @return array<int,array<int,true>> role id → permission ids it holds */
    public function matrix(): array
    {
        $out = [];
        foreach ($this->db()->all('SELECT role_id, permission_id FROM role_permissions') as $row) {
            $out[(int)$row['role_id']][(int)$row['permission_id']] = true;
        }
        return $out;
    }

    /** Replace one role's permissions. */
    public function syncPermissions(int $roleId, array $permissionIds): void
    {
        $db = $this->db();
        $db->begin();
        try {
            $db->run('DELETE FROM role_permissions WHERE role_id = ?', [$roleId]);
            foreach (array_unique($permissionIds) as $pid) {
                $db->insert('role_permissions', ['role_id' => $roleId, 'permission_id' => (int)$pid]);
            }
            $db->commit();
        } catch (\Throwable $e) {
            $db->rollback();
            throw $e;
        }
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db()->one('SELECT * FROM roles WHERE slug = ?', [$slug]);
    }
}
