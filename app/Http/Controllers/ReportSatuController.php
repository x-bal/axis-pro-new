<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportSatu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportSatuController extends Controller
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
            'file_upload' => 'required',
            'time_upload' => 'required',
        ]);

        if ($request->hasFile('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $file) {
                $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                $filename = 'files/report-satu/' . $name;

                if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                    \Image::make($file)->fit(600, null)->save(\public_path('storage/files/report-satu/' . $name), 90);
                } else {
                    $file->storeAs('files/report-satu/', $name);
                }

                ReportSatu::create([
                    'case_list_id' => $request->case_list_id,
                    'file_upload' => $filename,
                    'time_upload' => Carbon::now()
                ]);
            }
        }

        $caseList = CaseList::find($request->case_list_id);
        if ($caseList->ia_status == 0) {
            $caseList->update([
                'ia_amount' => $request->ia_amount,
                'ia_status' => 1,
                'ia_date' => Carbon::now(),
                'now_update' => Carbon::now(),
                'pr_limit' => Carbon::now()->addDay(14),
                'file_status_id' => 3
            ]);
        } else {
            $caseList->update([
                'ia_amount' => $request->ia_amount,
            ]);
        }


        return back()->with('success', 'Report satu has been uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportSatu  $reportSatu
     * @return \Illuminate\Http\Response
     */
    public function show(ReportSatu $reportSatu)
    {
        return Storage::download($reportSatu->file_upload);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportSatu  $reportSatu
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportSatu $reportSatu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportSatu  $reportSatu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportSatu $reportSatu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportSatu  $reportSatu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportSatu $reportSatu)
    {
        //
    }
}
