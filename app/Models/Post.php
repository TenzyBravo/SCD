<?php
declare(strict_types=1);

namespace App\Models;

final class Post extends Model
{
    protected string $table = 'posts';

    public const TYPES = ['news' => 'News', 'press' => 'Press Release', 'story' => 'Success Story'];

    /** @return array<int,array<string,mixed>> */
    public function adminList(): array
    {
        return $this->db()->all(
            'SELECT p.*, u.name AS editor_name FROM posts p LEFT JOIN users u ON u.id = COALESCE(p.updated_by, p.created_by)
              WHERE p.deleted_at IS NULL ORDER BY COALESCE(p.published_at, p.created_at) DESC'
        );
    }

    /** @return array<int,array<string,mixed>> */
    public function published(?string $type = null): array
    {
        $sql    = "SELECT * FROM posts WHERE deleted_at IS NULL AND status = 'published' AND published_at <= NOW()";
        $params = [];
        if ($type !== null) {
            $sql .= ' AND type = ?';
            $params[] = $type;
        }
        return $this->db()->all($sql . ' ORDER BY published_at DESC', $params);
    }

    public function findPublishedBySlug(string $slug): ?array
    {
        return $this->db()->one(
            "SELECT * FROM posts WHERE slug = ? AND deleted_at IS NULL AND status = 'published' AND published_at <= NOW()",
            [$slug]
        );
    }

    /** A slug unique across all posts, including deleted ones (the column is UNIQUE). */
    public function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = mb_substr(slugify($title), 0, 200);
        $slug = $base;
        for ($i = 2; ; $i++) {
            $taken = $this->db()->scalar(
                'SELECT 1 FROM posts WHERE slug = ? AND id <> ? LIMIT 1',
                [$slug, $ignoreId ?? 0]
            );
            if (!$taken) {
                return $slug;
            }
            $slug = $base . '-' . $i;
        }
    }
}
