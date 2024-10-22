<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'project_name',
        'project_sdm',

    ];

    /**
     * Get the client that owns the project.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
