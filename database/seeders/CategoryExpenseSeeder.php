<?php

namespace Database\Seeders;

use App\Models\CategoryExpense;
use Illuminate\Database\Seeder;

class CategoryExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryExpense::create(['nama_kategory' => 'ACCOM', 'desc' => 'Accomodation']);
        CategoryExpense::create(['nama_kategory' => 'FC', 'desc' => 'File Charge']);
        CategoryExpense::create(['nama_kategory' => 'GENEX', 'desc' => 'General Expense']);
        CategoryExpense::create(['nama_kategory' => 'KM', 'desc' => 'Per Kilometer Charge']);
        CategoryExpense::create(['nama_kategory' => 'TE', 'desc' => 'Travel Expense']);
        CategoryExpense::create(['nama_kategory' => 'SUST', 'desc' => 'Subsistence']);
    }
}
