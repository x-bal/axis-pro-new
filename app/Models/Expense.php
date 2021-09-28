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
        return $this->belongsTo(CategoryExpense::class, 'category_expense_id');
    }

    public function caselist()
    {
        return $this->belongsTo(CaseList::class);
    }
}
