<?php

namespace App\Livewire\Sessions;

use App\Models\Attendance;
use App\Models\LearningSession;
use App\Services\AttendanceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class AttendanceButton extends Component
{
    use AuthorizesRequests;

    public LearningSession $session;
    public bool $alreadyCheckedIn = false;
    public bool $canCheckIn = false;
    public string $windowMessage = '';

    protected $listeners = [
        'attendanceRecorded' => 'refreshStatus',
    ];

    public function mount(string $sessionId): void
    {
        $this->session = LearningSession::with('topic.course')->findOrFail($sessionId);
        $this->authorize('checkIn', $this->session);

        $this->refreshStatus();
    }

    public function refreshStatus(): void
    {
        $now = now();
        $windowStart = $this->session->start_at->copy()->subMinutes(15);
        $windowEnd = $this->session->end_at->copy();

        $this->alreadyCheckedIn = Attendance::where('session_id', $this->session->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($now->lt($windowStart)) {
            $this->canCheckIn = false;
            $this->windowMessage = 'Absensi belum dibuka.';
            return;
        }

        if ($now->gt($windowEnd)) {
            $this->canCheckIn = false;
            $this->windowMessage = 'Absensi sudah ditutup.';
            return;
        }

        $this->canCheckIn = true;
        $this->windowMessage = $now->gt($this->session->start_at)
            ? 'Anda masih bisa check-in, status akan tercatat late bila lewat jam mulai.'
            : 'Absensi aktif.';
    }

    public function checkIn(AttendanceService $attendanceService): void
    {
        $this->authorize('checkIn', $this->session);

        $attendanceService->checkIn(auth()->id(), $this->session->id);

        $this->emit('attendanceRecorded');
        session()->flash('success', 'Absensi berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.sessions.attendance-button');
    }
}