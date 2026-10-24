<?php
declare(strict_types=1);

namespace App\Models;

final class Resource extends Model
{
    protected string $table = 'resources';

    public const CATEGORIES = [
        'guideline' => 'Guidelines',
        'manual'    => 'Manuals',
        'template'  => 'Templates',
        'research'  => 'Research',
    ];

    /** @return array<int,array<string,mixed>> */
    public function adminList(): array
    {
        return $this->db()->all(
            'SELECT * FROM resources WHERE deleted_at IS NULL ORDER BY category ASC, sort_order ASC, title ASC'
        );
    }

    /** @return array<string,array<int,array<string,mixed>>> category → published resources */
    public function publishedByCategory(): array
    {
        $out = [];
        foreach ($this->db()->all(
            "SELECT * FROM resources WHERE deleted_at IS NULL AND status = 'published'
              ORDER BY sort_order ASC, title ASC"
        ) as $row) {
            $out[$row['category']][] = $row;
        }
        return $out;
    }
}
