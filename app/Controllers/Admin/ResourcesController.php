<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Flash;
use App\Core\View;
use App\Models\Model;
use App\Models\Resource;

final class ResourcesController extends ContentController
{
    protected string $path   = 'toolkits';
    protected string $entity = 'resource';
    protected string $label  = 'Resource';

    protected function model(): Model
    {
        return new Resource();
    }

    protected function rules(): array
    {
        return [
            'category'    => 'required|in:' . implode(',', array_keys(Resource::CATEGORIES)),
            'title'       => 'required|max:200',
            'description' => 'nullable|max:2000',
            'status'      => 'required|in:draft,published',
            'sort_order'  => 'nullable|int|between:0,9999',
        ];
    }

    protected function labels(): array
    {
        return ['sort_order' => 'Display order'];
    }

    protected function formData(): array
    {
        return ['categories' => Resource::CATEGORIES];
    }

    protected function columns(array $data, ?array $existing): array
    {
        $file = $this->upload('file', 'document', $existing, $existing['file_path'] ?? null);
        if ($file['path'] === null) {
            $old = $_POST;
            unset($old['_token']);
            Flash::withErrors(['file' => ['Choose a file to upload.']], $old);
            Flash::error('Choose a file to upload.');
            View::redirect("admin/{$this->path}/new");
        }
        $replaced = $file['mime'] !== null;

        return [
            'category'    => $data['category'],
            'title'       => $data['title'],
            'description' => $data['description'] === '' ? null : $data['description'],
            'file_path'   => $file['path'],
            'file_name'   => $replaced ? $file['name'] : $existing['file_name'],
            'file_size'   => $replaced ? $file['size'] : (int)$existing['file_size'],
            'status'      => $data['status'],
            'sort_order'  => (int)($data['sort_order'] ?: 0),
        ];
    }
}
