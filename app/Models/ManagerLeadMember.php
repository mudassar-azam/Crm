<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerLeadMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'manager_id',
        'lead_id',
        'member_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
