<?php

namespace App\Http\Controllers;

use App\Models\FeeBased;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FeeBasedController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('fee-based-access'), 403);

        return view('feebased.index', [
            'feebased' => FeeBased::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('fee-based-create'), 403);

        return view('feebased.create', [
            'feebased' => new FeeBased()
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('fee-based-create'), 403);

        $attr = $this->validate($request, [
            'adjusted_idr' => 'required',
            'adjusted_usd' => 'required',
            'fee_idr' => 'required',
            'fee_usd' => 'required',
            'category_fee' => 'required'
        ]);

        FeeBased::create($attr);
        return redirect()->route('fee-based.index')->with('success', 'Fee based has been created');
    }

    public function show($id)
    {
        //
    }

    public function edit(FeeBased $feeBased)
    {
        abort_unless(Gate::allows('fee-based-edit'), 403);


        return view('feebased.edit', [
            'feebased' => $feeBased
        ]);
    }

    public function update(Request $request, FeeBased $feeBased)
    {
        abort_unless(Gate::allows('fee-based-edit'), 403);

        $attr =  $this->validate($request, [
            'adjusted_idr' => 'required',
            'adjusted_usd' => 'required',
            'fee_idr' => 'required',
            'fee_usd' => 'required',
            'category_fee' => 'required'
        ]);

        $feeBased->update($attr);
        return redirect()->route('fee-based.index')->with('success', 'Fee based has been updated');
    }

    public function destroy(FeeBased $feeBased)
    {
        abort_unless(Gate::allows('fee-based-delete'), 403);

        $feeBased->delete();
        return redirect()->route('fee-based.index')->with('success', 'Fee based has been created');
    }
}
