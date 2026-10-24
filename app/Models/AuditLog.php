<?php
declare(strict_types=1);

namespace App\Models;

final class AuditLog extends Model
{
    protected string $table = 'audit_logs';
    protected bool $softDeletes = false;

    /** @return array{0:string,1:array<string,mixed>} WHERE clause and its parameters */
    private function filters(array $f): array
    {
        $where  = ['1 = 1'];
        $params = [];
        if (!empty($f['user_id'])) {
            $where[] = 'a.user_id = :user_id';
            $params['user_id'] = (int)$f['user_id'];
        }
        if (!empty($f['action'])) {
            $where[] = 'a.action LIKE :action';
            $params['action'] = $f['action'] . '%';
        }
        return [implode(' AND ', $where), $params];
    }

    public function countFiltered(array $f): int
    {
        [$where, $params] = $this->filters($f);
        return (int)$this->db()->scalar("SELECT COUNT(*) FROM audit_logs a WHERE $where", $params);
    }

    /** @return array<int,array<string,mixed>> */
    public function page(array $f, int $limit, int $offset): array
    {
        [$where, $params] = $this->filters($f);
        return $this->db()->all(
            "SELECT a.*, u.name AS user_name
               FROM audit_logs a LEFT JOIN users u ON u.id = a.user_id
              WHERE $where
              ORDER BY a.id DESC
              LIMIT :limit OFFSET :offset",
            $params + ['limit' => $limit, 'offset' => $offset]
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function recent(int $limit = 8): array
    {
        return $this->page([], $limit, 0);
    }

    /** @return array<int,string> */
    public function actions(): array
    {
        return array_column($this->db()->all('SELECT DISTINCT action FROM audit_logs ORDER BY action'), 'action');
    }
}
