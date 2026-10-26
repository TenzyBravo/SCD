<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Audit;
use App\Core\Controller;
use App\Core\Flash;
use App\Core\Uploader;
use App\Core\View;
use App\Models\Model;

/**
 * List / create / edit / delete for one kind of public content.
 * Subclasses describe the fields; this class does the rest.
 */
abstract class ContentController extends Controller
{
    /** URL segment under /admin, and the folder of the views, e.g. "news". */
    protected string $path;
    /** Audit entity type, e.g. "post". */
    protected string $entity;
    /** Human name of one item, e.g. "News item". */
    protected string $label;

    abstract protected function model(): Model;

    /** Validation rules for the form. */
    abstract protected function rules(): array;

    /**
     * Turn validated input into database columns, storing any uploaded files.
     * $existing is the current row when editing, null when creating.
     */
    abstract protected function columns(array $data, ?array $existing): array;

    protected function labels(): array
    {
        return [];
    }

    /** Extra data every form view needs (e.g. select options). */
    protected function formData(): array
    {
        return [];
    }

    public function index(): void
    {
        $this->view("admin/{$this->path}/index", ['rows' => $this->model()->adminList()], 'admin');
    }

    public function create(): void
    {
        $this->view("admin/{$this->path}/form", ['item' => null] + $this->formData(), 'admin');
    }

    public function store(): void
    {
        $data = $this->validate($this->rules(), $this->labels(), "admin/{$this->path}/new");
        $cols = $this->columns($data, null);
        $id   = $this->model()->create($cols);
        Audit::log($this->entity . '.created', $this->entity, $id, $this->title($cols), null, $this->loggable($cols));
        Flash::success("{$this->label} created.");
        $this->redirect("admin/{$this->path}");
    }

    public function edit(string $id): void
    {
        $item = $this->findOrFail($id);
        $this->view("admin/{$this->path}/form", ['item' => $item] + $this->formData(), 'admin');
    }

    public function update(string $id): void
    {
        $item = $this->findOrFail($id);
        $data = $this->validate($this->rules(), $this->labels(), "admin/{$this->path}/{$item['id']}/edit");
        $cols = $this->columns($data, $item);
        $this->model()->updateById((int)$item['id'], $cols);

        // Record only the fields that actually changed.
        $old = $new = [];
        foreach ($this->loggable($cols) as $key => $value) {
            if ((string)($item[$key] ?? '') !== (string)($value ?? '')) {
                $old[$key] = $item[$key] ?? null;
                $new[$key] = $value;
            }
        }
        Audit::log($this->entity . '.updated', $this->entity, (int)$item['id'], $this->title($cols), $old, $new);
        Flash::success("{$this->label} saved.");
        $this->redirect("admin/{$this->path}");
    }

    public function destroy(string $id): void
    {
        $item = $this->findOrFail($id);
        $this->model()->softDelete((int)$item['id']);
        Audit::log($this->entity . '.deleted', $this->entity, (int)$item['id'], $this->title($item));
        Flash::success("{$this->label} deleted.");
        $this->redirect("admin/{$this->path}");
    }

    // ------------------------------------------------------------ helpers
    protected function findOrFail(string $id): array
    {
        $item = ctype_digit($id) ? $this->model()->find((int)$id) : null;
        if ($item === null) {
            $this->fail(404, "That {$this->label} no longer exists.");
        }
        return $item;
    }

    /**
     * Store an optional upload. Returns the new path, or $current when no file
     * was chosen; on an invalid file, sends the editor back to the form.
     */
    protected function upload(string $field, string $kind, ?array $existing, ?string $current): array
    {
        $result = Uploader::handle($field, $kind);
        if ($result['error'] !== null) {
            $old = $_POST;
            unset($old['_token']);
            Flash::withErrors([$field => [$result['error']]], $old);
            Flash::error($result['error']);
            View::redirect($existing === null ? "admin/{$this->path}/new" : "admin/{$this->path}/{$existing['id']}/edit");
        }
        if ($result['path'] === null) {
            return ['path' => $current] + $result;
        }
        return $result;
    }

    /** Long text is left out of the audit trail to keep it readable. */
    private function loggable(array $cols): array
    {
        return array_diff_key($cols, array_flip(['body', 'description', 'how_to_apply', 'bio']));
    }

    private function title(array $row): string
    {
        $label = isset($row['name']) ? $row['name'] . ' (' . ($row['title'] ?? '') . ')' : ($row['title'] ?? '');
        return mb_substr((string)$label, 0, 200);
    }
}
