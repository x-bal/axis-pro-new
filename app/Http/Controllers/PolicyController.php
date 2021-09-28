<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PolicyController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('type-of-business-access'), 403);

        return view('typeofbusiness.index', [
            'policies' => Policy::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('type-of-business-create'), 403);

        return view('typeofbusiness.create', [
            'policy' => new Policy
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('type-of-business-create'), 403);

        $attr = $this->validate($request, [
            'type_policy' => 'required',
            'abbreviation' => 'required'
        ]);
        $attr['is_active'] = 1;

        Policy::create($attr);
        return redirect()->route('type-of-business.index')->with('success', 'Type of business has been created');
    }

    public function show(Policy $policy)
    {
        //
    }

    public function edit(Policy $typeOfBusiness)
    {
        abort_unless(Gate::allows('type-of-business-edit'), 403);

        return view('typeofbusiness.edit', [
            'policy' => $typeOfBusiness
        ]);
    }

    public function update(Request $request, Policy $typeOfBusiness)
    {
        abort_unless(Gate::allows('type-of-business-edit'), 403);

        $attr = $this->validate($request, [
            'type_policy' => 'required',
            'abbreviation' => 'required'
        ]);

        $typeOfBusiness->update($attr);
        return redirect()->route('type-of-business.index')->with('success', 'Type of business has been updated');
    }

    public function destroy($id)
    {
        abort_unless(Gate::allows('type-of-business-delete'), 403);
        $type = Policy::find($id);
        $type->delete();
        return redirect()->route('type-of-business.index')->with('success', 'Type of business has been deleted');
    }
}
