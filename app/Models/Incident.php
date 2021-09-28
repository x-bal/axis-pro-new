<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function incident()
    {
        return $this->belongsTo(incident::class, 'incident_id');
    }
}
