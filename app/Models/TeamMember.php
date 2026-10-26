<?php
declare(strict_types=1);

namespace App\Models;

final class TeamMember extends Model
{
    protected string $table = 'team_members';

    /** Which part of a portrait stays visible when it is cropped to a square. */
    public const POSITIONS = [
        'top'    => ['Top — keep the head in view', 'center top'],
        'upper'  => ['Upper third',                 'center 25%'],
        'center' => ['Centre',                      'center center'],
    ];

    /** @return array<int,array<string,mixed>> */
    public function adminList(): array
    {
        return $this->db()->all(
            'SELECT * FROM team_members WHERE deleted_at IS NULL ORDER BY sort_order ASC, id ASC'
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function published(): array
    {
        return $this->db()->all(
            "SELECT * FROM team_members WHERE deleted_at IS NULL AND status = 'published'
              ORDER BY sort_order ASC, id ASC"
        );
    }
}
