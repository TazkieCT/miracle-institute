<?php

namespace App\Livewire\Admin\Materials;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Material;
use App\Models\Topic;
use App\Models\User;
use Livewire\Component;

class MaterialIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $topic_id = '';
    public string $uploader_id = '';
    public string $name = '';
    public string $visibility = 'Public';
    public string $path = '';
    public string $external_url = '';
    public string $type = 'pdf';
    public string $status = 'active';
    public int $sort_order = 0;

    protected function rules(): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'uploader_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'visibility' => 'required|string|max:50',
            'path' => 'nullable|string|max:255',
            'external_url' => 'nullable|url|max:255',
            'type' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = Material::findOrFail($id);

        $this->editingId = $row->id;
        $this->topic_id = $row->topic_id;
        $this->uploader_id = $row->uploader_id;
        $this->name = $row->name;
        $this->visibility = $row->visibility;
        $this->path = $row->path ?? '';
        $this->external_url = $row->external_url ?? '';
        $this->type = $row->type;
        $this->status = $row->status;
        $this->sort_order = (int) ($row->sort_order ?? 0);
    }

    public function save(): void
    {
        $this->validate();

        Material::updateOrCreate(
            ['id' => $this->editingId],
            [
                'topic_id' => $this->topic_id,
                'uploader_id' => $this->uploader_id,
                'name' => $this->name,
                'visibility' => $this->visibility,
                'path' => $this->path,
                'external_url' => $this->external_url,
                'type' => $this->type,
                'status' => $this->status,
                'sort_order' => $this->sort_order,
            ]
        );

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        Material::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.materials.index', [
            'rows' => Material::with(['topic', 'uploader'])
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate($this->perPage),
            'topics' => Topic::orderBy('name')->get(),
            'users' => User::orderBy('first_name')->get(),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'topic_id', 'uploader_id', 'name', 'visibility', 'path', 'external_url', 'type', 'status', 'sort_order']);
        $this->visibility = 'Public';
        $this->type = 'pdf';
        $this->status = 'active';
        $this->sort_order = 0;
    }
}