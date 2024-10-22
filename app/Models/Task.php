<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'assign_to',
        'start_date',
        'due_date',
        'priority',
        'bucket',
        'remarks',
        'status',
        'description',
        'attachment',
        'location',
        'task_completion_status',
        'assign_by',
    ];
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}
