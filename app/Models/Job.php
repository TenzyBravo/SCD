<?php
declare(strict_types=1);

namespace App\Models;

final class Job extends Model
{
    protected string $table = 'jobs';

    /** @return array<int,array<string,mixed>> */
    public function adminList(): array
    {
        return $this->db()->all(
            'SELECT * FROM jobs WHERE deleted_at IS NULL ORDER BY sort_order ASC, id DESC'
        );
    }

    /** Published vacancies whose deadline (if any) has not passed. @return array<int,array<string,mixed>> */
    public function open(): array
    {
        return $this->db()->all(
            "SELECT * FROM jobs WHERE deleted_at IS NULL AND status = 'published'
                AND (deadline IS NULL OR deadline >= CURDATE())
              ORDER BY sort_order ASC, id DESC"
        );
    }
}
