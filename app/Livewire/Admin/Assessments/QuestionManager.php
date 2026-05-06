<?php

namespace App\Livewire\Admin\Assessments;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Str;
use Livewire\Component;

class QuestionManager extends Component
{
    public Assessment $assessment;

    public bool $openModal = false;

    public ?string $editingId = null;
    public string $question = '';
    public int $correctIndex = 0;
    public int $sort_order = 0;

    public array $options = [];

    public function mount(string $assessmentId): void
    {
        $this->assessment = Assessment::with('course')->findOrFail($assessmentId);
        $this->resetForm();
    }

    protected function defaultOptions(): array
    {
        return [
            ['id' => null, 'option_text' => ''],
            ['id' => null, 'option_text' => ''],
            ['id' => null, 'option_text' => ''],
            ['id' => null, 'option_text' => ''],
        ];
    }

    protected function rules(): array
    {
        return [
            'question' => 'required|string|min:10',
            'options' => 'required|array|size:4',
            'options.*.option_text' => 'required|string|min:1',
            'correctIndex' => 'required|integer|min:0|max:3',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
        $this->openModal = true;
    }

    public function edit(string $id): void
    {
        $row = Question::with('options')->findOrFail($id);

        $this->editingId = $row->id;
        $this->question = $row->question;
        $this->sort_order = (int) $row->sort_order;

        $sorted = $row->options->sortBy('sort_order')->values();

        $this->options = $sorted->map(fn ($opt) => [
            'id' => $opt->id,
            'option_text' => $opt->option_text,
        ])->toArray();

        $this->correctIndex = max(0, (int) $sorted->search(fn ($opt) => $opt->is_correct));
        $this->openModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $nextSort = Question::where('assessment_id', $this->assessment->id)->max('sort_order');
        $nextSort = $nextSort ? $nextSort + 1 : 1;

        $question = Question::updateOrCreate(
            ['id' => $this->editingId],
            [
                'assessment_id' => $this->assessment->id,
                'question_type' => 'mcq',
                'question' => $this->question,
                'sort_order' => $this->editingId ? $this->sort_order : $nextSort,
            ]
        );

        QuestionOption::where('question_id', $question->id)->delete();

        foreach ($this->options as $i => $opt) {
            QuestionOption::create([
                'id' => (string) Str::uuid(),
                'question_id' => $question->id,
                'option_text' => $opt['option_text'],
                'is_correct' => $i === $this->correctIndex,
                'sort_order' => $i + 1,
            ]);
        }

        $this->resetForm();
        $this->openModal = false;
        session()->flash('success', 'Question berhasil disimpan.');
    }

    public function delete(string $id): void
    {
        Question::findOrFail($id)->delete();
        session()->flash('success', 'Question berhasil dihapus.');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'question', 'correctIndex', 'sort_order']);
        $this->options = $this->defaultOptions();
        $this->correctIndex = 0;
        $this->sort_order = 0;
    }

    public function render()
    {
        $questions = Question::with('options')
            ->where('assessment_id', $this->assessment->id)
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        return view('livewire.admin.assessments.question-manager', [
            'questions' => $questions,
            'questionsCount' => $questions->count(),
            'attemptsCount' => AssessmentAttempt::where('assessment_id', $this->assessment->id)->count(),
        ])->layout('layouts.admin');
    }
}