<?php

namespace App\Http\Controllers;

use App\Imports\ExpenseImport;
use App\Models\CaseList;
use App\Models\Expense;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'adjuster' => 'required',
            'category' => 'required',
            'qty' => 'required',
            'amount' => 'required',
            'tanggal' => 'required',
        ]);

        try {
            DB::beginTransaction();

            Expense::create([
                'case_list_id' => $request->case_list_id,
                'adjuster' => $request->adjuster,
                'name' => $request->name,
                'qty' => $request->qty,
                'amount' => $request->amount,
                'total' => intval($request->qty * $request->amount),
                'category_expense' => $request->category,
                'tanggal' => $request->tanggal
            ]);

            DB::commit();

            return back()->with('success', 'Expense successfully created');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_upload' => 'required',
            'file_upload.*' => 'max:10240|mimes:xlsx,xls',
        ]);
        try {

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
        if (Expense::find($request->id)->is_active == 0) {
            $this->validate($request, [
                'name' => 'required',
                'qty' => 'required',
                'nominal' => 'required'
            ]);
            $expense = Expense::find($request->id);
            Log::create([
                'nama' => auth()->user()->nama_lengkap,
                'old' => $expense->amount,
                'new' => $request->nominal,
                'datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                'expense_id' => $request->id
            ]);
            $expense->update([
                'name' => $request->name,
                'qty' => $request->qty,
                'amount' => $request->nominal,
                'total' => $request->nominal * $request->qty
            ]);
            return back()->with('success', 'Berhasil Update Amount');
        } else {
            return back()->with('error', 'Expense has been used');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if ($expense->is_active == 0) {
            foreach ($expense->log as $log) {
                $log->delete();
            }
            // Log::create([
            //     'nama' => auth()->user()->nama_lengkap,
            //     'old' => $expense->amount,
            //     'new' => $expense->amount,
            //     'datetime' => Carbon::now()->format('Y-m-d H:i:s'),
            //     'expense_id' => $expense->id
            // ]);
            $expense->delete();
            return back()->with('success', 'Expense has been deleted');
        } else {
            return back()->with('error', 'Expense has been used');
        }
    }

    public function download()
    {
        return Response::download('expense/new-example-expense.xlsx');
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
