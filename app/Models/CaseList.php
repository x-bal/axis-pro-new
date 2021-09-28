<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseList extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function member()
    {
        return $this->hasMany(MemberInsurance::class, 'file_no_outstanding');
    }
    public function insurance()
    {
        return $this->belongsTo(Client::class, 'insurance_id');
    }
    public function adjuster()
    {
        return $this->belongsTo(User::class, 'adjuster_id');
    }
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'incident_id');
    }
    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id');
    }

    public function filesurvey()
    {
        return $this->hasMany(FileSurvey::class);
    }

    public function claimdocuments()
    {
        return $this->hasMany(ClaimDocument::class);
    }

    public function reportsatu()
    {
        return $this->hasMany(ReportSatu::class);
    }

    public function reportdua()
    {
        return $this->hasMany(ReportDua::class);
    }
    public function reporttiga()
    {
        return $this->hasMany(ReportTiga::class);
    }
    public function reportempat()
    {
        return $this->hasMany(ReportEmpat::class);
    }
    public function reportlima()
    {
        return $this->hasMany(ReportLima::class);
    }

    public function status()
    {
        return $this->belongsTo(FileStatus::class, 'file_status_id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
    public function hasInvoice(): bool
    {
        return $this->invoice()->exists();
    }
}
