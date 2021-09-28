<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportLima;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportLimaController extends Controller
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
            'file_upload' => 'required|max:10240|mimes:png, jpg, jpeg, pdf, xls, xlsx, doc, docx',
            'time_upload' => 'required',
        ]);

        if ($request->hasFile('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $file) {
                $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                $filename = 'files/report-lima/' . $name;

                if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                    \Image::make($file)->resize(480, 360)->save(\public_path('storage/files/report-lima/' . $name), 90);
                } else {
                    $file->storeAs('files/report-lima/', $name);
                }

                ReportLima::create([
                    'case_list_id' => $request->case_list_id,
                    'file_upload' => $filename,
                    'time_upload' => Carbon::now()
                ]);
            }
        }

        $caseList = CaseList::find($request->case_list_id);

        $caseList->update([
            'fr_amount' => $request->fr_amount,
            'claim_amount' => $request->claim_amount,
            'fr_status' => 1,
            'fr_date' => Carbon::now(),
            'now_update' => Carbon::now(),
            'file_status_id' => 5
        ]);

        return back()->with('success', 'Report lima has been uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportLima  $reportLima
     * @return \Illuminate\Http\Response
     */
    public function show(ReportLima $reportLima)
    {
        return Storage::download($reportLima->file_upload);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportLima  $reportLima
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportLima $reportLima)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportLima  $reportLima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportLima $reportLima)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportLima  $reportLima
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportLima $reportLima)
    {
        //
    }
}
