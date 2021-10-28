<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryExpense::class, 'category_expense');
    }

    public function caselist()
    {
        return $this->belongsTo(CaseList::class, 'case_list_id');
    }

    public function adjuster()
    {
        return $this->belongsTo(User::class, 'adjuster');
    }
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
