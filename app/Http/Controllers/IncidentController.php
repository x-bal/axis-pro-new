<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IncidentController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('cause-of-loss-access'), 403);

        return view('causeofloss.index', [
            'incidents' => Incident::get()
        ]);
    }

    public function create()
    {
        abort_unless(Gate::allows('cause-of-loss-create'), 403);

        return view('causeofloss.create');
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('cause-of-loss-create'), 403);

        $form = $this->validate($request, [
            'type_incident' => 'required',
            'description' => 'required'
        ]);
        $form['is_active'] = 1;

        Incident::create($form);
        return redirect()->route('cause-of-loss.index')->with('success', 'Cause of loss has been created');
    }

    public function show(Incident $incident)
    {
        //
    }

    public function edit(Incident $causeOfLoss)
    {
        abort_unless(Gate::allows('cause-of-loss-edit'), 403);

        return view('causeofloss.edit', [
            'incident' => $causeOfLoss
        ]);
    }

    public function update(Request $request, Incident $causeOfLoss)
    {
        abort_unless(Gate::allows('cause-of-loss-edit'), 403);

        $form = $this->validate($request, [
            'type_incident' => 'required',
            'description' => 'required'
        ]);

        $causeOfLoss->update($form);
        return redirect()->route('cause-of-loss.index')->with('success', 'Cause of loss has been updated');
    }

    public function destroy(Incident $causeOfLoss)
    {
        abort_unless(Gate::allows('cause-of-loss-delete'), 403);

        $causeOfLoss->delete();
        return redirect()->route('cause-of-loss.index')->with('success', 'Cause of loss has been deleted');
    }
}
