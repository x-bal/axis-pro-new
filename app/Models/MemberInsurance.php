<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberInsurance extends Model
{
    protected $guarded = [];
    public function caselist()
    {
        return $this->belongsTo(CaseList::class, 'file_no_outstanding');
    }

    public function insurance()
    {
        return $this->belongsTo(Client::class, 'member_insurance');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'member_insurance');
    }
}
