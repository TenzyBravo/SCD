<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Model;
use App\Models\TeamMember;

final class TeamController extends ContentController
{
    protected string $path   = 'team';
    protected string $entity = 'team_member';
    protected string $label  = 'Team member';

    protected function model(): Model
    {
        return new TeamMember();
    }

    protected function rules(): array
    {
        return [
            'name'           => 'required|max:120',
            'title'          => 'required|max:120',
            'bio'            => 'nullable|max:1500',
            'image_position' => 'required|in:' . implode(',', array_keys(TeamMember::POSITIONS)),
            'status'         => 'required|in:draft,published',
            'sort_order'     => 'nullable|int|between:0,9999',
        ];
    }

    protected function labels(): array
    {
        return ['title' => 'Role / title', 'bio' => 'Short bio', 'image_position' => 'Photo crop', 'sort_order' => 'Display order'];
    }

    protected function formData(): array
    {
        return ['positions' => TeamMember::POSITIONS];
    }

    protected function columns(array $data, ?array $existing): array
    {
        $image = $this->upload('image', 'image', $existing, $existing['image_path'] ?? null);
        if (!empty($_POST['remove_image']) && $image['mime'] === null) {
            $image['path'] = null;
        }
        return [
            'name'           => $data['name'],
            'title'          => $data['title'],
            'bio'            => $data['bio'] === '' ? null : $data['bio'],
            'image_path'     => $image['path'],
            'image_position' => $data['image_position'],
            'status'         => $data['status'],
            'sort_order'     => (int)($data['sort_order'] ?: 0),
        ];
    }
}
