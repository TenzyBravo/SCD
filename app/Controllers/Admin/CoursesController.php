<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Course;
use App\Models\Model;

final class CoursesController extends ContentController
{
    protected string $path   = 'training';
    protected string $entity = 'course';
    protected string $label  = 'Course';

    protected function model(): Model
    {
        return new Course();
    }

    protected function rules(): array
    {
        return [
            'title'      => 'required|max:200',
            'tag'        => 'nullable|max:80',
            'details'    => 'required|max:400',
            'status'     => 'required|in:draft,published',
            'sort_order' => 'nullable|int|between:0,9999',
        ];
    }

    protected function labels(): array
    {
        return ['tag' => 'Format / location', 'sort_order' => 'Display order'];
    }

    protected function columns(array $data, ?array $existing): array
    {
        $image = $this->upload('image', 'image', $existing, $existing['image_path'] ?? null);
        if (!empty($_POST['remove_image']) && $image['mime'] === null) {
            $image['path'] = null;
        }
        return [
            'title'      => $data['title'],
            'tag'        => $data['tag'] === '' ? null : $data['tag'],
            'details'    => $data['details'],
            'image_path' => $image['path'],
            'status'     => $data['status'],
            'sort_order' => (int)($data['sort_order'] ?: 0),
        ];
    }
}
