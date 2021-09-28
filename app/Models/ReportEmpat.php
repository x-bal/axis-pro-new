<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportEmpat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function caselist()
    {
        return $this->belongsTo(CaseList::class);
    }
}
