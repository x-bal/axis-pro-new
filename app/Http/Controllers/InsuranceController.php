<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class InsuranceController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('insurance-access'), 403);

        return view('insurance.index', [
            'clients' => Client::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('insurance-create'), 403);

        return view('insurance.create', [
            'client' => new Client(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('insurance-create'), 403);

        $attr = $this->validate($request, [
            'brand' => 'required',
            'name' => 'required',
            'address' => 'required',
            'no_telp' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'status' => 'required',
            'ppn' => 'required',
            'type' => 'required',
            'picture' => 'required',
        ]);

        try {
            $picture = $request->file('picture');
            $pictureUrl = $picture->storeAs('images/insurance', $request->name . '_' . \Str::random(15) . '.' . $picture->extension());
            // Client::create($request->all());
            $attr['picture'] = $pictureUrl;
            $attr['is_active'] = 1;

            Client::create($attr);
            return redirect()->route('insurance.index')->with('success', 'Insurance has been created');
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function show(Client $insurance)
    {
        //
    }

    public function edit(Client $insurance)
    {
        abort_unless(Gate::allows('insurance-edit'), 403);

        return view('insurance.edit', [
            'client' => $insurance,
        ]);
    }

    public function update(Request $request, Client $insurance)
    {
        abort_unless(Gate::allows('insurance-edit'), 403);

        $attr = $this->validate($request, [
            'brand' => 'required',
            'name' => 'required',
            'address' => 'required',
            'no_telp' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'status' => 'required',
            'ppn' => 'required',
            'type' => 'required',
        ]);

        try {
            if ($request->picture) {
                $picture = $request->file('picture');
                Storage::delete($insurance->picture);
                $pictureUrl = $picture->storeAs('images/insurance', \Str::random(15) . '.' . $picture->extension());
                $attr['picture'] = $pictureUrl;
                $insurance->update($attr);
                return back();
            } else {
                $insurance->update($attr);
                return redirect()->route('insurance.index')->with('success', 'Insurance has been updated');
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function destroy(Client $insurance)
    {
        abort_unless(Gate::allows('insurance-delete'), 403);

        Storage::delete($insurance->picture);
        $insurance->delete();
        return redirect()->route('insurance.index')->with('success', 'Insurance has been deleted');
    }
}
