<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function caselist()
    {
        return $this->belongsTo(CaseList::class, 'case_list_id');
    }

    public function member()
    {
        return $this->belongsTo(Client::class, 'member_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
