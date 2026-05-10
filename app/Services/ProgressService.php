<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\CourseEnrollment;
use App\Models\Material;
use App\Models\MaterialProgress;
use App\Models\Topic;
use App\Models\TopicProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProgressService
{
    public function markMaterialViewed(string $userId, string $materialId): MaterialProgress
    {
        $material = Material::query()
            ->with(['topic'])
            ->findOrFail($materialId);

        $this->requireEnrollment($userId, $material->topic->course_id);

        return DB::transaction(function () use ($userId, $material) {
            $progress = MaterialProgress::query()->firstOrNew([
                'user_id' => $userId,
                'material_id' => $material->id,
            ]);

            $progress->status = 'in_progress';
            $progress->started_at ??= now();
            $progress->save();

            return $progress;
        });
    }

    public function markMaterialCompleted(string $userId, string $materialId): array
    {
        $material = Material::query()
            ->with(['topic.materials', 'topic.videoSessions'])
            ->findOrFail($materialId);

        $enrollment = $this->requireEnrollment($userId, $material->topic->course_id);

        return DB::transaction(function () use ($userId, $material, $enrollment) {
            $materialProgress = MaterialProgress::query()->firstOrNew([
                'user_id' => $userId,
                'material_id' => $material->id,
            ]);

            $materialProgress->status = 'completed';
            $materialProgress->started_at ??= now();
            $materialProgress->completed_at = now();
            $materialProgress->save();

            $snapshot = $this->topicCompletionSnapshot($userId, $material->topic_id);

            $topicProgress = TopicProgress::query()->firstOrNew([
                'course_enrollment_id' => $enrollment->id,
                'topic_id' => $material->topic_id,
            ]);

            $topicProgress->status = $snapshot['can_complete'] ? 'completed' : 'in_progress';
            $topicProgress->started_at ??= now();

            if ($snapshot['can_complete']) {
                $topicProgress->completed_at = now();
            } else {
                $topicProgress->completed_at = null;
            }

            $topicProgress->save();

            return [
                'material_progress' => $materialProgress,
                'topic_progress' => $topicProgress,
                'snapshot' => $snapshot,
            ];
        });
    }

    public function topicCompletionSnapshot(string $userId, string $topicId): array
    {
        $topic = Topic::query()
            ->with([
                'materials:id,topic_id,name,sort_order',
                'videoSessions:id,topic_id,title,start_at,end_at,status',
            ])
            ->findOrFail($topicId);

        $this->requireEnrollment($userId, $topic->course_id);

        $materialIds = $topic->materials->pluck('id')->all();

        $materialProgresses = MaterialProgress::query()
            ->where('user_id', $userId)
            ->whereIn('material_id', $materialIds)
            ->get()
            ->keyBy('material_id');

        $completedMaterials = $topic->materials->filter(function ($material) use ($materialProgresses) {
            return ($materialProgresses[$material->id]->status ?? null) === 'completed';
        });

        $incompleteMaterials = $topic->materials->filter(function ($material) use ($materialProgresses) {
            return ($materialProgresses[$material->id]->status ?? null) !== 'completed';
        });

        $qualifyingSessions = $topic->videoSessions->filter(function ($session) {
            return $session->status !== 'cancelled';
        });

        $sessionIds = $qualifyingSessions->pluck('id')->all();

        $attendedSessionIds = Attendance::query()
            ->where('user_id', $userId)
            ->whereIn('video_session_id', $sessionIds)
            ->whereIn('status', ['present', 'late'])
            ->pluck('video_session_id')
            ->all();

        $missingSessions = $qualifyingSessions->filter(function ($session) use ($attendedSessionIds) {
            return ! in_array($session->id, $attendedSessionIds, true);
        });

        $allMaterialsCompleted = $topic->materials->isEmpty()
            ? true
            : $completedMaterials->count() === $topic->materials->count();

        $allSessionsAttended = $qualifyingSessions->isEmpty()
            ? true
            : count($attendedSessionIds) === $qualifyingSessions->count();

        $reasons = [];

        if (! $allMaterialsCompleted) {
            $reasons[] = 'Semua materi harus selesai terlebih dahulu.';
        }

        if (! $allSessionsAttended) {
            $reasons[] = 'Attendance sesi video belum lengkap.';
        }

        if ($topic->videoSessions->whereIn('status', ['scheduled', 'ongoing'])->isNotEmpty()) {
            $reasons[] = 'Masih ada sesi yang belum selesai.';
        }

        return [
            'total_materials' => $topic->materials->count(),
            'completed_materials' => $completedMaterials->count(),
            'incomplete_materials' => $incompleteMaterials->pluck('name')->values()->all(),
            'all_materials_completed' => $allMaterialsCompleted,
            'total_sessions' => $qualifyingSessions->count(),
            'attended_sessions' => count($attendedSessionIds),
            'missing_sessions' => $missingSessions->pluck('title')->values()->all(),
            'all_sessions_attended' => $allSessionsAttended,
            'can_complete' => $allMaterialsCompleted && $allSessionsAttended && $topic->videoSessions->whereIn('status', ['scheduled', 'ongoing'])->isEmpty(),
            'reasons' => $reasons,
        ];
    }

    public function syncTopicCompletion(string $userId, string $topicId): TopicProgress
    {
        $snapshot = $this->topicCompletionSnapshot($userId, $topicId);

        $topic = Topic::query()
            ->findOrFail($topicId);

        $enrollment = $this->requireEnrollment($userId, $topic->course_id);

        return DB::transaction(function () use ($snapshot, $enrollment, $topicId) {
            $topicProgress = TopicProgress::query()->firstOrNew([
                'course_enrollment_id' => $enrollment->id,
                'topic_id' => $topicId,
            ]);

            if ($snapshot['can_complete']) {
                $topicProgress->status = 'completed';
                $topicProgress->started_at ??= now();
                $topicProgress->completed_at = now();
            } else {
                $topicProgress->status = 'in_progress';
                $topicProgress->started_at ??= now();
                $topicProgress->completed_at = null;
            }

            $topicProgress->save();

            return $topicProgress;
        });
    }

    public function recalculateTopicCompletion(string $userId, string $topicId): TopicProgress
    {
        return $this->syncTopicCompletion($userId, $topicId);
    }

    private function requireEnrollment(string $userId, string $courseId): CourseEnrollment
    {
        $enrollment = CourseEnrollment::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if (! $enrollment) {
            throw ValidationException::withMessages([
                'course' => 'User belum terdaftar pada course ini.',
            ]);
        }

        return $enrollment;
    }
}