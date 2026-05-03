<?php

namespace App\Livewire\Assessments;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AssessmentTaker extends Component
{
    public Assessment $assessment;
    public AssessmentAttempt $attempt;

    public $questions = [];
    public array $answers = [];

    public ?int $timeLeft = null;
    public int $currentIndex = 0;
    public ?int $timeLimit = null;
    public ?int $startedAt = null;

    public bool $openSubmit = false;

    // FIX: pastikan integer
    public ?int $redirectAttemptId = null;

    public function mount(Assessment $assessment): void
    {
        $this->assessment = $assessment;
        $this->attempt = $this->resolveAttempt();

        $this->questions = $this->assessment->questions()
            ->with('options')
            ->orderBy('sort_order')
            ->get()
            ->values();

        $this->timeLimit = $this->assessment->time_limit_minutes;
        $this->startedAt = $this->attempt->started_at?->timestamp;

        $this->answers = $this->attempt->answers()
            ->get()
            ->mapWithKeys(fn ($a) => [
                (string) $a->question_id =>
                    (string) ($a->question_option_id ?? $a->answer_text ?? ''),
            ])
            ->toArray();

        $this->initTimer();

        // jika sudah pernah submit → langsung redirect
        if ($this->attempt->submitted_at) {
            $this->redirectAttemptId = (int) $this->attempt->id;
            return;
        }

        // auto submit jika waktu habis (server-side guard)
        if ($this->timeLeft !== null && $this->timeLeft <= 0) {
            $this->finalizeSubmission();
            $this->redirectAttemptId = (int) $this->attempt->id;
        }
    }

    private function resolveAttempt(): AssessmentAttempt
    {
        $last = AssessmentAttempt::where('assessment_id', $this->assessment->id)
            ->where('user_id', Auth::id())
            ->latest('attempt_no')
            ->first();

        if ($last && !$last->submitted_at) {
            return $last;
        }

        $attemptNo = $last ? $last->attempt_no + 1 : 1;

        return AssessmentAttempt::create([
            'assessment_id' => $this->assessment->id,
            'user_id' => Auth::id(),
            'attempt_no' => $attemptNo,
            'started_at' => now(),
        ]);
    }

    private function initTimer(): void
    {
        if (!$this->assessment->time_limit_minutes || !$this->attempt->started_at) {
            $this->timeLeft = null;
            return;
        }

        $end = $this->attempt->started_at
            ->copy()
            ->addMinutes($this->assessment->time_limit_minutes);

        $this->timeLeft = now()->diffInSeconds($end, false);
    }

    // 🔥 SINGLE SOURCE OF TRUTH SAVE
    public function saveAnswer(int $questionId, $value): void
    {
        if ($this->attempt->submitted_at) return;

        $question = $this->questions->firstWhere('id', $questionId);
        if (!$question) return;

        $value = is_string($value) ? trim($value) : $value;

        // MCQ
        if ($question->question_type === 'mcq') {
            $optionId = $value ? (int) $value : null;

            if (!$optionId) {
                AssessmentAnswer::where('attempt_id', $this->attempt->id)
                    ->where('question_id', $questionId)
                    ->delete();

                unset($this->answers[(string) $questionId]);
                return;
            }

            AssessmentAnswer::updateOrCreate(
                [
                    'attempt_id' => $this->attempt->id,
                    'question_id' => $questionId,
                ],
                [
                    'question_option_id' => $optionId,
                    'answer_text' => null,
                ]
            );

            $this->answers[(string) $questionId] = (string) $optionId;
            return;
        }

        // TEXT
        $text = (string) $value;

        if ($text === '') {
            AssessmentAnswer::where('attempt_id', $this->attempt->id)
                ->where('question_id', $questionId)
                ->delete();

            unset($this->answers[(string) $questionId]);
            return;
        }

        AssessmentAnswer::updateOrCreate(
            [
                'attempt_id' => $this->attempt->id,
                'question_id' => $questionId,
            ],
            [
                'question_option_id' => null,
                'answer_text' => $text,
            ]
        );

        $this->answers[(string) $questionId] = $text;
    }

    private function finalizeSubmission(): void
    {
        if ($this->attempt->submitted_at) return;

        $answers = $this->attempt->answers()
            ->with('question.options')
            ->get();

        $correct = 0;

        foreach ($answers as $answer) {
            $question = $answer->question;

            if (!$question) continue;

            if ($question->question_type === 'mcq') {
                $correctOption = $question->options->firstWhere('is_correct', true);

                $isCorrect = $correctOption &&
                    (int) $answer->question_option_id === (int) $correctOption->id;
            } else {
                $isCorrect =
                    strtolower(trim($answer->answer_text)) ===
                    strtolower(trim($question->correct_text_answer));
            }

            $answer->update(['is_correct' => $isCorrect]);

            if ($isCorrect) $correct++;
        }

        $total = $this->questions->count();

        $score = $total > 0
            ? (int) round(($correct / $total) * 100)
            : 0;

        $this->attempt->update([
            'score' => $score,
            'passed' => $score >= $this->assessment->passing_grade,
            'submitted_at' => now(),
        ]);
    }

    public function submit(array $clientAnswers = [])
    {
        // sync last answers dari client
        foreach ($clientAnswers as $qId => $val) {
            $this->saveAnswer((int) $qId, $val);
        }

        $this->finalizeSubmission();
        $this->openSubmit = false;

        return redirect()->route('assessments.result', (int) $this->attempt->id);
    }

    public function goToQuestion(int $index): void
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentIndex = $index;
        }
    }

    public function nextQuestion(): void
    {
        if ($this->currentIndex < count($this->questions) - 1) {
            $this->currentIndex++;
        }
    }

    public function prevQuestion(): void
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    public function render()
    {
        if ($this->redirectAttemptId) {
            return redirect()->route('assessments.result', $this->redirectAttemptId);
        }

        return view('livewire.assessments.assessment-taker')
            ->layout('layouts.student');
    }
}