<?php
declare(strict_types=1);

namespace App\Models;

final class Course extends Model
{
    protected string $table = 'courses';

    /** @return array<int,array<string,mixed>> */
    public function adminList(): array
    {
        return $this->db()->all(
            'SELECT * FROM courses WHERE deleted_at IS NULL ORDER BY sort_order ASC, id DESC'
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function published(): array
    {
        return $this->db()->all(
            "SELECT * FROM courses WHERE deleted_at IS NULL AND status = 'published'
              ORDER BY sort_order ASC, id DESC"
        );
    }
}
