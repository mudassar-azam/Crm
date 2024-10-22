<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BGV extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'resource_id',
    ];
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
