<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gmail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function caselist()
    {
        return $this->belongsTo(CaseList::class, 'caselist_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'gmail_id');
    }
}
