<?php

namespace App\Livewire\Admin\Assessments;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Assessment;
use App\Models\Topic;
use Livewire\Component;

class AssessmentIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $topic_id = '';
    public string $title = '';
    public int $passing_grade = 70;
    public bool $randomize_questions = false;
    public ?int $question_limit = null;
    public ?int $time_limit_minutes = null;
    public string $status = 'active';

    protected function rules(): array
    {
        return [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'passing_grade' => 'required|integer|min:0|max:100',
            'randomize_questions' => 'boolean',
            'question_limit' => 'nullable|integer|min:1',
            'time_limit_minutes' => 'nullable|integer|min:1',
            'status' => 'required|string|max:50',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = Assessment::findOrFail($id);

        $this->editingId = $row->id;
        $this->topic_id = $row->topic_id;
        $this->title = $row->title;
        $this->passing_grade = (int) $row->passing_grade;
        $this->randomize_questions = (bool) $row->randomize_questions;
        $this->question_limit = $row->question_limit;
        $this->time_limit_minutes = $row->time_limit_minutes;
        $this->status = $row->status;
    }

    public function save(): void
    {
        $this->validate();

        Assessment::updateOrCreate(
            ['id' => $this->editingId],
            [
                'topic_id' => $this->topic_id,
                'title' => $this->title,
                'passing_grade' => $this->passing_grade,
                'randomize_questions' => $this->randomize_questions,
                'question_limit' => $this->question_limit,
                'time_limit_minutes' => $this->time_limit_minutes,
                'status' => $this->status,
            ]
        );

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        Assessment::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.assessments.index', [
            'rows' => Assessment::with('topic.course')
                ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate($this->perPage),
            'topics' => Topic::with('course')->orderBy('name')->get(),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'topic_id', 'title', 'passing_grade', 'randomize_questions', 'question_limit', 'time_limit_minutes', 'status']);
        $this->passing_grade = 70;
        $this->status = 'active';
        $this->randomize_questions = false;
    }
}