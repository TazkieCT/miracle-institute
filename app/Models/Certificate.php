<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function resolvedCourse(): ?Course
    {
        if ($this->relationLoaded('course') && $this->course) {
            return $this->course;
        }

        if ($this->course()->exists()) {
            return $this->course()->first();
        }

        $user = $this->relationLoaded('user') ? $this->user : $this->user()->first();

        if (! $user) {
            return null;
        }

        $enrollments = $user->relationLoaded('courseEnrollments')
            ? $user->courseEnrollments
            : $user->courseEnrollments()->with('course')->get();

        if ($enrollments->count() !== 1) {
            return null;
        }

        return $enrollments->first()?->course;
    }
}
