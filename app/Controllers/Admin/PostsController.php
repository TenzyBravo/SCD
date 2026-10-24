<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Model;
use App\Models\Post;

final class PostsController extends ContentController
{
    protected string $path   = 'news';
    protected string $entity = 'post';
    protected string $label  = 'Story';

    protected function model(): Model
    {
        return new Post();
    }

    protected function rules(): array
    {
        return [
            'type'         => 'required|in:' . implode(',', array_keys(Post::TYPES)),
            'title'        => 'required|max:200',
            'excerpt'      => 'nullable|max:400',
            'body'         => 'required',
            'status'       => 'required|in:draft,published',
            'published_on' => 'nullable|date',
        ];
    }

    protected function labels(): array
    {
        return ['excerpt' => 'Summary', 'body' => 'Story text', 'published_on' => 'Publication date'];
    }

    protected function formData(): array
    {
        return ['types' => Post::TYPES];
    }

    protected function columns(array $data, ?array $existing): array
    {
        $image = $this->upload('image', 'image', $existing, $existing['image_path'] ?? null);
        if (!empty($_POST['remove_image']) && $image['mime'] === null) {
            $image['path'] = null;
        }

        // A chosen date wins; otherwise keep the original date, or use now when first published.
        $publishedAt = $existing['published_at'] ?? null;
        if (!empty($data['published_on'])) {
            $keepTime    = $publishedAt !== null && str_starts_with($publishedAt, $data['published_on']);
            $publishedAt = $keepTime ? $publishedAt : $data['published_on'] . ' 08:00:00';
        } elseif ($publishedAt === null && $data['status'] === 'published') {
            $publishedAt = date('Y-m-d H:i:s');
        }

        $titleChanged = $existing === null || $existing['title'] !== $data['title'];
        return [
            'type'         => $data['type'],
            'title'        => $data['title'],
            // The address stays stable once published so shared links keep working.
            'slug'         => $titleChanged && ($existing['published_at'] ?? null) === null
                ? (new Post())->uniqueSlug($data['title'], $existing === null ? null : (int)$existing['id'])
                : $existing['slug'],
            'excerpt'      => $data['excerpt'] === '' ? null : $data['excerpt'],
            'body'         => $data['body'],
            'image_path'   => $image['path'],
            'status'       => $data['status'],
            'published_at' => $publishedAt,
        ];
    }
}
