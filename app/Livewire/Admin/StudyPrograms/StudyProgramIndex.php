<?php

namespace App\Livewire\Admin\StudyPrograms;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\StudyProgram;
use Livewire\Component;
use Illuminate\Support\Str;

class StudyProgramIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $title = '';
    public string $description = '';
    public string $status = 'active';

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = StudyProgram::findOrFail($id);

        $this->editingId = $row->id;
        $this->title = $row->title;
        $this->description = $row->description;
        $this->status = $row->status;
    }

    public function save(): void
    {
        $this->validate();

        StudyProgram::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'status' => $this->status,
            ]
        );

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        StudyProgram::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.study-programs.index', [
            'rows' => StudyProgram::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate($this->perPage),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description', 'status']);
        $this->status = 'active';
    }
}