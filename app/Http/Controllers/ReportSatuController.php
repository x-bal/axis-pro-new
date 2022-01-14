<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportSatu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        $request->validate([
            'case_list_id' => 'required',
            'file_upload' => 'required|max:20480',
            'file_upload.*' => 'max:20480|mimes:xlsx,xls,docx,doc,pdf,mp4',
            'time_upload' => 'required',
            'date_report' => 'required',
        ]);

        try {
            if ($request->hasFile('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $file) {
                    $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                    $filename = 'files/report-satu/' . $name;
                    $path = 'files/report-satu/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
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
                    'ia_amount' => str_replace('.', '', $request->ia_amount),
                    'ia_status' => 1,
                    'ia_curr' => $request->curr,
                    'ia_date' => Carbon::createFromFormat('d/m/Y', $request->date_report)->format('Y-m-d'),
                    'now_update' => Carbon::now(),
                    'pr_limit' =>  Carbon::createFromFormat('d/m/Y', $request->date_report)->addDays(14)->format('Y-m-d'),
                    'file_status_id' => 3
                ]);
            } else {
                $caseList->update([
                    'ia_amount' => str_replace('.', '', $request->ia_amount),
                    'ia_curr' => $request->curr,
                ]);
            }

            return back()->with('success', 'Report satu has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportSatu  $reportSatu
     * @return \Illuminate\Http\Response
     */
    public function show(ReportSatu $reportSatu)
    {
        $file = explode('.', $reportSatu->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportSatu->file_upload);
        } else {
            return Storage::download($reportSatu->file_upload);
        }
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
        $file = explode('.', $reportSatu->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($reportSatu->file_upload);
        } else {
            Storage::delete($reportSatu->file_upload);
        }

        $reportSatu->delete();

        return back()->with('success', 'File Report 1 has been deleted');
    }
}
