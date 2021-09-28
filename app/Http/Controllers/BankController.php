<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BankController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('bank-access'), 403);

        return view('bank.index', [
            'banks' => Bank::get(),
            'kurs' => Currency::first()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('bank-create'), 403);

        return view('bank.create', [
            'bank' => new Bank()
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('bank-create'), 403);

        $attr = $this->validate($request, [
            'bank_name' => 'required',
            'no_account' => 'required',
            'currency' => 'required'
        ]);

        Bank::create($attr);
        return redirect()->route('bank.index')->with('success', 'Bank has been created');
    }

    public function show($id)
    {
        //
    }

    public function edit(Bank $bank)
    {
        abort_unless(Gate::allows('bank-edit'), 403);

        return view('bank.edit', [
            'bank' => $bank
        ]);
    }

    public function update(Request $request, Bank $bank)
    {
        abort_unless(Gate::allows('bank-edit'), 403);

        $attr = $this->validate($request, [
            'bank_name' => 'required',
            'no_account' => 'required',
            'currency' => 'required'
        ]);

        $bank->update($attr);
        return redirect()->route('bank.index')->with('success', 'Bank has been updated');
    }

    public function destroy(Bank $bank)
    {
        abort_unless(Gate::allows('bank-delete'), 403);

        $bank->delete();
        return redirect()->route('bank.index')->with('success', 'Bank has been deleted');
    }
}
