<?php

namespace App\Livewire\Admin\Sessions;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Course;
use App\Models\Topic;
use App\Models\VideoSession;
use Carbon\Carbon;
use Livewire\Component;

class VideoSessionIndex extends Component
{
    use WithAdminTableState;

    public bool $showModal = false;
    public ?string $editingId = null;

    public string $topic_id = '';
    public string $title = '';
    public string $zoom_link = '';
    public ?string $record_link = null;
    public ?string $start_at = null;
    public ?string $end_at = null;
    public ?string $status = 'scheduled';

    public string $courseFilter = '';
    public string $topicFilter = '';
    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'courseFilter' => ['except' => ''],
        'topicFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected function rules(): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'zoom_link' => 'required|url|max:255',
            'record_link' => 'nullable|url|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
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

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(string $id): void
    {
        $row = VideoSession::findOrFail($id);

        $this->editingId = $row->id;
        $this->topic_id = $row->topic_id;
        $this->title = $row->title;
        $this->zoom_link = $row->zoom_link;
        $this->record_link = $row->record_link;
        $this->start_at = optional($row->start_at)->format('Y-m-d\TH:i');
        $this->end_at = optional($row->end_at)->format('Y-m-d\TH:i');
        $this->status = $row->status;

        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        VideoSession::updateOrCreate(
            ['id' => $this->editingId],
            [
                'topic_id' => $this->topic_id,
                'title' => $this->title,
                'zoom_link' => $this->zoom_link,
                'record_link' => $this->record_link,
                'start_at' => Carbon::parse($this->start_at),
                'end_at' => Carbon::parse($this->end_at),
                'status' => $this->status,
            ]
        );

        $this->resetForm();
        $this->showModal = false;

        session()->flash('success', 'Session berhasil disimpan.');
    }

    public function delete(string $id): void
    {
        VideoSession::findOrFail($id)->delete();
        session()->flash('success', 'Session berhasil dihapus.');
    }

    public function render()
    {
        $baseQuery = VideoSession::with(['topic.course', 'attendances'])
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('title', 'like', "%{$this->search}%")
                        ->orWhere('zoom_link', 'like', "%{$this->search}%")
                        ->orWhere('record_link', 'like', "%{$this->search}%")
                        ->orWhereHas('topic', fn ($t) => $t->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('topic.course', fn ($c) => $c->where('title', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->courseFilter, fn ($q) => $q->whereHas('topic', fn ($t) => $t->where('course_id', $this->courseFilter)))
            ->when($this->topicFilter, fn ($q) => $q->where('topic_id', $this->topicFilter))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter));

        return view('livewire.admin.sessions.index', [
            'rows' => (clone $baseQuery)->latest('start_at')->paginate($this->perPage),
            'courses' => Course::orderBy('title')->get(),
            'topics' => Topic::with('course')->orderBy('name')->get(),
            'stats' => [
                'total' => (clone $baseQuery)->count(),
                'scheduled' => (clone $baseQuery)->where('status', 'scheduled')->count(),
                'ongoing' => (clone $baseQuery)->where('status', 'ongoing')->count(),
                'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
                'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
            ],
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId',
            'topic_id',
            'title',
            'zoom_link',
            'record_link',
            'start_at',
            'end_at',
            'status',
        ]);

        $this->status = 'scheduled';
    }
}