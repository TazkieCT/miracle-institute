<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CourseUser extends Model
{
    use HasUuids;

    protected $table = 'course_user';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'course_id',
        'user_id',
        'role_type',
        'status',
        'invited_by',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function permissions()
    {
        return $this->hasMany(CourseUserPermission::class);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role_type === 'owner') {
            return true;
        }

        return $this->permissions()
            ->where('permission', $permission)
            ->exists();
    }
}