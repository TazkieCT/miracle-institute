<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'check_in_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(LearningSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}