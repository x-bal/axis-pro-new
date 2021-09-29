<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportTiga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportTigaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $attr = $request->validate([
            'case_list_id' => 'required',
            'file_upload' => 'required|max:10240',
            'time_upload' => 'required',
        ]);

        if ($request->hasFile('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $file) {
                $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                $filename = 'files/report-tiga/' . $name;
                $path = 'files/report-tiga/' . $name;

                if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                    \Image::make($file)->resize(480, 360)->save($path, 90);
                } else {
                    $file->storeAs('files/report-tiga/', $name);
                }

                ReportTiga::create([
                    'case_list_id' => $request->case_list_id,
                    'file_upload' => $filename,
                    'time_upload' => Carbon::now()
                ]);
            }
        }

        $caseList = CaseList::find($request->case_list_id);

        if ($caseList->ir_status == 1) {
            if ($caseList->ir_st_status == 0) {
                $caseList->update([
                    'ir_st_amount' => $request->ir_st_amount,
                    'ir_st_status' => 1,
                    'ir_nd_amount' => $request->ir_nd_amount,
                    'ir_nd_status' => 1,
                    'ir_st_date' => Carbon::now(),
                    'ir_nd_date' => Carbon::now(),
                    'pa_limit' => Carbon::now()->addDay(14),
                    'now_update' => Carbon::now(),
                    'date_complete' => $request->date_complete,
                ]);
            } else {
                $caseList->update([
                    'ir_st_amount' => $request->ir_st_amount,
                    'ir_nd_amount' => $request->ir_nd_amount,
                    'now_update' => Carbon::now(),
                    'date_complete' => $request->date_complete,
                ]);
            }
        } else {
            if ($caseList->pa_status == 0) {
                $caseList->update([
                    'pa_amount' => $request->pa_amount,
                    'pa_status' => 1,
                    'pa_date' => Carbon::now(),
                    'fr_limit' => Carbon::now()->addDay(7),
                    'now_update' => Carbon::now(),
                ]);
            } else {
                $caseList->update([
                    'pa_amount' => $request->pa_amount,
                    'now_update' => Carbon::now(),
                ]);
            }
        }

        return back()->with('success', 'Report tiga has been uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTiga  $reportTiga
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTiga $reportTiga)
    {
        return Storage::download($reportTiga->file_upload);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportTiga  $reportTiga
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportTiga $reportTiga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportTiga  $reportTiga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportTiga $reportTiga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportTiga  $reportTiga
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportTiga $reportTiga)
    {
        //
    }
}
