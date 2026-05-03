<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withPivot('assigned_at')
            ->withTimestamps();
    }

    public function permissions() 
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}