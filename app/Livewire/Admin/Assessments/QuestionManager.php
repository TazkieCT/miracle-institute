<?php

namespace App\Livewire\Admin\Assessments;

use App\Models\Assessment;
use App\Models\Question;
use App\Models\QuestionOption;
use Livewire\Component;

class QuestionManager extends Component
{
    public Assessment $assessment;

    public ?string $editingId = null;
    public string $question_type = 'mcq';
    public string $question = '';
    public ?string $correct_text_answer = null;
    public ?string $explanation = null;
    public int $sort_order = 0;

    public array $options = [];

    public function mount(string $assessmentId): void
    {
        $this->assessment = Assessment::with('topic.course')->findOrFail($assessmentId);
        $this->options = $this->makeDefaultOptions();
    }

    protected function makeDefaultOptions(): array
    {
        return [
            ['id' => null, 'option_text' => '', 'is_correct' => false, 'sort_order' => 1],
            ['id' => null, 'option_text' => '', 'is_correct' => false, 'sort_order' => 2],
            ['id' => null, 'option_text' => '', 'is_correct' => false, 'sort_order' => 3],
            ['id' => null, 'option_text' => '', 'is_correct' => false, 'sort_order' => 4],
        ];
    }

    protected function rules(): array
    {
        return [
            'question_type' => 'required|in:mcq,text',
            'question' => 'required|string',
            'correct_text_answer' => 'nullable|string',
            'explanation' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'options' => 'array',
            'options.*.option_text' => 'nullable|string',
            'options.*.is_correct' => 'boolean',
            'options.*.sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = Question::with('options')->findOrFail($id);

        $this->editingId = $row->id;
        $this->question_type = $row->question_type;
        $this->question = $row->question;
        $this->correct_text_answer = $row->correct_text_answer;
        $this->explanation = $row->explanation;
        $this->sort_order = (int) $row->sort_order;

        $this->options = $row->options->map(function ($opt) {
            return [
                'id' => $opt->id,
                'option_text' => $opt->option_text,
                'is_correct' => (bool) $opt->is_correct,
                'sort_order' => (int) $opt->sort_order,
            ];
        })->values()->all();

        if (count($this->options) < 4) {
            $this->options = array_merge($this->options, array_slice($this->makeDefaultOptions(), count($this->options)));
        }
    }

    public function addOption(): void
    {
        $this->options[] = [
            'id' => null,
            'option_text' => '',
            'is_correct' => false,
            'sort_order' => count($this->options) + 1,
        ];
    }

    public function removeOption(int $index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
        foreach ($this->options as $i => $option) {
            $this->options[$i]['sort_order'] = $i + 1;
        }
    }

    public function save(): void
    {
        $this->validate();

        if ($this->question_type === 'mcq') {
            $correctCount = collect($this->options)->where('is_correct', true)->count();

            if ($correctCount !== 1) {
                $this->addError('options', 'MCQ harus memiliki tepat 1 jawaban benar.');
                return;
            }
        }

        $question = Question::updateOrCreate(
            ['id' => $this->editingId],
            [
                'assessment_id' => $this->assessment->id,
                'question_type' => $this->question_type,
                'question' => $this->question,
                'correct_text_answer' => $this->question_type === 'text' ? $this->correct_text_answer : null,
                'explanation' => $this->explanation,
                'sort_order' => $this->sort_order,
            ]
        );

        QuestionOption::where('question_id', $question->id)->delete();

        if ($this->question_type === 'mcq') {
            foreach ($this->options as $option) {
                if (trim((string) ($option['option_text'] ?? '')) === '') {
                    continue;
                }

                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['option_text'],
                    'is_correct' => (bool) $option['is_correct'],
                    'sort_order' => (int) $option['sort_order'],
                ]);
            }
        }

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        Question::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.assessments.question-manager', [
            'questions' => Question::with('options')
                ->where('assessment_id', $this->assessment->id)
                ->orderBy('sort_order')
                ->get(),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'question_type', 'question', 'correct_text_answer', 'explanation', 'sort_order', 'options']);
        $this->question_type = 'mcq';
        $this->sort_order = 0;
        $this->options = $this->makeDefaultOptions();
    }
}