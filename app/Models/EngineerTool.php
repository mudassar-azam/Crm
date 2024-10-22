<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineerTool extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

}
