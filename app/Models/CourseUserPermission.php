<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CourseUserPermission extends Model
{
    use HasUuids;

    protected $table = 'course_user_permissions';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'course_user_id',
        'permission',
        'granted_by',
    ];

    public function courseUser()
    {
        return $this->belongsTo(CourseUser::class);
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }
}