<?php

namespace App\Imports;

use App\Models\Expense;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ExpenseImport implements ToModel
{
    public function __construct($case_list_id)
    {
        $this->case_list_id = $case_list_id;
    }

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Expense([
            'case_list_id' => $this->case_list_id,
            'name' => $row[0],
            'amount' => $row[1],
            'category_expense_id' => $row[2],
        ]);
    }
}
