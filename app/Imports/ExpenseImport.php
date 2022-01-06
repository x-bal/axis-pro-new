<?php

namespace App\Imports;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpenseImport implements ToCollection, WithHeadingRow
{
    public function __construct($case_list_id)
    {
        $this->case_list_id = $case_list_id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $miliseconds = ($row['tanggal'] - 25569) * 86400 * 1000;
            $tgl = $miliseconds / 1000;

            Expense::create([
                'case_list_id' => $this->case_list_id,
                'adjuster' => $row['adjuster'],
                'name' => $row['nama'],
                'qty' => $row['qty'],
                'amount' => $row['amount'],
                'category_expense' => $row['category'],
                'tanggal' => date('Y-m-d', $tgl),
                'total' => $row['amount'] * $row['qty'],
            ]);
        }
    }
}
