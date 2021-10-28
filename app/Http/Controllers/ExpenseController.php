<?php

namespace App\Http\Controllers;

use App\Imports\ExpenseImport;
use App\Models\CaseList;
use App\Models\Expense;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense.index', [
            'expense' => Expense::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //code...

            $request->validate([
                'file_upload' => 'required',
                'file_upload.*' => 'max:10240|mimes:xlsx,xls',
            ]);

            $case = CaseList::find($request->case_list_id);

            $case->update([
                'is_expense' => 1
            ]);

            Excel::import(new ExpenseImport($request->case_list_id), $request->file('file_upload'));
            return back()->with('success', 'Import expense successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense = Expense::find($request->id);
        Log::create([
            'nama' => auth()->user()->nama_lengkap,
            'old' => $expense->amount,
            'new' => $request->nominal,
            'datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            'expense_id' => $request->id
        ]);
        $expense->update([
            'amount' => $request->nominal
        ]);
        return back()->with('success', 'Berhasil Update Amount');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense has been deleted');
    }

    public function download()
    {
        return Response::download('expense/example-expense.xlsx');
    }
    public function laporan(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);
        $expense = Expense::whereBetween('tanggal', [$request->from, $request->to])->get();
        return view('expense.laporan', [
            'expense' => $expense
        ]);
    }
}
