<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function insurance()
    {
        return $this->belongsTo(Client::class, 'insurance_id');
    }

    public function member()
    {
        return $this->belongsTo(MemberInsurance::class, 'member_insurance');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'member_id');
    }
}
