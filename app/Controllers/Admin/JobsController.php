<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Job;
use App\Models\Model;

final class JobsController extends ContentController
{
    protected string $path   = 'jobs';
    protected string $entity = 'job';
    protected string $label  = 'Vacancy';

    protected function model(): Model
    {
        return new Job();
    }

    protected function rules(): array
    {
        return [
            'title'        => 'required|max:200',
            'location'     => 'nullable|max:120',
            'commitment'   => 'nullable|max:160',
            'deadline'     => 'nullable|date',
            'description'  => 'required|max:4000',
            'how_to_apply' => 'nullable|max:2000',
            'status'       => 'required|in:draft,published',
            'sort_order'   => 'nullable|int|between:0,9999',
        ];
    }

    protected function labels(): array
    {
        return ['commitment' => 'Type / hours', 'how_to_apply' => 'How to apply', 'sort_order' => 'Display order'];
    }

    protected function columns(array $data, ?array $existing): array
    {
        $blankToNull = static fn(string $v): ?string => $v === '' ? null : $v;
        return [
            'title'        => $data['title'],
            'location'     => $blankToNull($data['location']),
            'commitment'   => $blankToNull($data['commitment']),
            'deadline'     => $blankToNull($data['deadline']),
            'description'  => $data['description'],
            'how_to_apply' => $blankToNull($data['how_to_apply']),
            'status'       => $data['status'],
            'sort_order'   => (int)($data['sort_order'] ?: 0),
        ];
    }
}
