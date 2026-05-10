<?php

namespace App\Livewire\Admin\Materials;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Course;
use App\Models\Material;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MaterialIndex extends Component
{
    use WithAdminTableState;

    public bool $showModal = false;
    public array $openTopics = [];

    public ?string $editingId = null;
    public ?string $topic_id = null;
    public string $name = '';
    public string $visibility = 'Public';
    public string $path = '';
    public string $external_url = '';
    public ?string $type = null;
    public string $status = 'active';
    public int $sort_order = 0;

    public string $search = '';
    public string $courseFilter = '';
    public string $topicFilter = '';
    public string $typeFilter = '';
    public string $visibilityFilter = '';
    public string $statusFilter = '';

    protected $listeners = ['materialDeleted' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'courseFilter' => ['except' => ''],
        'topicFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'visibilityFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:pdf,ppt,video',
            'path' => 'required_if:type,pdf,ppt|nullable|string|max:255',
            'external_url' => 'required_if:type,video|nullable|url|max:255',
            'visibility' => 'required|in:Public,Private',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function updatedCourseFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTopicFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTopicId(): void
    {
        if ($this->type && !in_array($this->type, $this->availableTypes, true)) {
            $this->type = $this->availableTypes[0] ?? null;
        }

        if ($this->type === 'video') {
            $this->path = '';
        } elseif (in_array($this->type, ['pdf', 'ppt'], true)) {
            $this->external_url = '';
        }
    }

    public function updatedType(): void
    {
        if ($this->type === 'video') {
            $this->path = '';
        } elseif (in_array($this->type, ['pdf', 'ppt'], true)) {
            $this->external_url = '';
        }
    }

    public function toggleTopic(string $id): void
    {
        if (in_array($id, $this->openTopics, true)) {
            $this->openTopics = array_values(array_diff($this->openTopics, [$id]));
            return;
        }

        $this->openTopics[] = $id;
    }

    public function create(?string $topicId = null): void
    {
        $this->resetForm();

        if ($topicId) {
            $this->topic_id = $topicId;

            if (!in_array($topicId, $this->openTopics, true)) {
                $this->openTopics[] = $topicId;
            }

            if ($this->availableTypes) {
                $this->type = $this->availableTypes[0];
            }
        }

        $this->showModal = true;
    }

    public function edit(string $id): void
    {
        $row = Material::findOrFail($id);

        $this->editingId = $row->id;
        $this->topic_id = $row->topic_id;
        $this->name = $row->name;
        $this->path = $row->path ?? '';
        $this->external_url = $row->external_url ?? '';
        $this->type = $row->type;
        $this->visibility = $row->visibility;
        $this->status = $row->status;
        $this->sort_order = (int) ($row->sort_order ?? 0);

        if (!in_array($row->topic_id, $this->openTopics, true)) {
            $this->openTopics[] = $row->topic_id;
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $currentCount = Material::where('topic_id', $this->topic_id)
            ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
            ->count();

        if (!$this->editingId && $currentCount >= 3) {
            throw ValidationException::withMessages([
                'topic_id' => 'Setiap topic hanya boleh memiliki maksimal 3 material.',
            ]);
        }

        $duplicateCheck = Material::where('topic_id', $this->topic_id)
            ->where('type', $this->type)
            ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
            ->exists();

        if ($duplicateCheck) {
            throw ValidationException::withMessages([
                'type' => 'Tipe material "' . strtoupper($this->type) . '" sudah ada di topic ini.',
            ]);
        }

        Material::updateOrCreate(
            ['id' => $this->editingId],
            [
                'topic_id' => $this->topic_id,
                'uploader_id' => auth()->id(),
                'name' => $this->name,
                'path' => $this->type === 'video' ? null : $this->path,
                'external_url' => $this->type === 'video' ? $this->external_url : null,
                'type' => $this->type,
                'visibility' => $this->visibility,
                'status' => $this->status,
                'sort_order' => $this->sort_order,
            ]
        );

        $this->resetForm();
        $this->dispatch('materialDeleted');

        session()->flash('success', 'Material berhasil disimpan.');
    }

    public function delete(string $id): void
    {
        Material::findOrFail($id)->delete();
        session()->flash('success', 'Material berhasil dihapus.');

        $this->resetForm();
        $this->dispatch('materialDeleted');
    }

    public function render()
    {
        $topics = Topic::with([
            'course',
            'materials' => fn ($q) => $q
                ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
                ->when($this->visibilityFilter, fn ($q) => $q->where('visibility', $this->visibilityFilter))
                ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->orderBy('sort_order')
                ->orderBy('name'),
        ])
            ->when($this->courseFilter, fn ($q) => $q->where('course_id', $this->courseFilter))
            ->when($this->topicFilter, fn ($q) => $q->where('id', $this->topicFilter))
            ->when($this->search, fn ($q) => $q->where(fn ($inner) =>
                $inner->where('name', 'like', "%{$this->search}%")
                    ->orWhereHas('course', fn ($cq) => $cq->where('title', 'like', "%{$this->search}%"))
                    ->orWhereHas('materials', fn ($mq) => $mq->where('name', 'like', "%{$this->search}%"))
            ))
            ->orderBy('course_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.materials.index', [
            'topics' => $topics,
            'courses' => Course::orderBy('title')->get(),
            'users' => User::orderBy('name')->get(),
        ])->layout('layouts.admin');
    }

    public function getAvailableTypesProperty(): array
    {
        if (!$this->topic_id) {
            return ['pdf', 'ppt', 'video'];
        }

        $usedTypes = Material::where('topic_id', $this->topic_id)
            ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
            ->distinct()
            ->pluck('type')
            ->toArray();

        $available = array_values(array_diff(['pdf', 'ppt', 'video'], $usedTypes));

        if ($this->editingId && $this->type && !in_array($this->type, $available, true)) {
            $available[] = $this->type;
        }

        return $available;
    }

    public function getIsTopicFullProperty(): array
    {
        return Topic::withCount('materials')
            ->get()
            ->mapWithKeys(fn ($topic) => [$topic->id => $topic->materials_count >= 3])
            ->all();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId',
            'topic_id',
            'name',
            'path',
            'external_url',
            'type',
            'visibility',
            'status',
            'sort_order',
        ]);

        $this->visibility = 'Public';
        $this->status = 'active';
        $this->sort_order = 0;
        $this->type = null;
        $this->showModal = false;
    }
}