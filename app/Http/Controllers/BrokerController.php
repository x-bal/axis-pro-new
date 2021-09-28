<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BrokerController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('broker-access'), 403);

        return view('broker.index', [
            'brokers' => Broker::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('broker-create'), 403);

        return view('broker.create', [
            'broker' => new Broker()
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('broker-create'), 403);
        $attr = $this->validate($request, [
            'nama_broker' => 'required',
            'telepon_broker' => 'required',
            'email_broker' => 'required|email',
            'alamat_broker' => 'required'
        ]);

        $attr['is_active'] = 1;

        Broker::create($attr);
        return redirect()->route('broker.index')->with('success', 'Broker has been created');
    }

    public function show($id)
    {
        //
    }

    public function edit(Broker $broker)
    {
        abort_unless(Gate::allows('broker-edit'), 403);

        return view('broker.edit', [
            'broker' => $broker
        ]);
    }

    public function update(Request $request, Broker $broker)
    {
        abort_unless(Gate::allows('broker-edit'), 403);

        $attr = $this->validate($request, [
            'nama_broker' => 'required',
            'telepon_broker' => 'required',
            'email_broker' => 'required|email',
            'alamat_broker' => 'required'
        ]);

        $broker->update($attr);
        return redirect()->route('broker.index')->with('success', 'Broker has been updated');
    }

    public function destroy(Broker $broker)
    {
        abort_unless(Gate::allows('broker-delete'), 403);

        $broker->delete();
        return redirect()->route('broker.index')->with('success', 'Broker has been created');
    }
}
