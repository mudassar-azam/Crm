<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'check_in',
        'check_out',
        'role_id',
        'role_type',
        'password',
        'vacation',
        'sick_leave',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isLead()
    {
        return $this->role->name === 'lead';
    }

    public function isMember()
    {
        return $this->role->name === 'member';
    }

    public function memberships() {
        return $this->hasMany(Member::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'manager_id');
    }
}
