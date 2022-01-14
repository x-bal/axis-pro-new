<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportTiga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        $request->validate([
            'case_list_id' => 'required',
            'file_upload' => 'required|max:20480',
            'file_upload.*' => 'max:20480|mimes:xlsx,xls,docx,doc,pdf,mp4',
            'time_upload' => 'required',
            'date_complete' => 'required',
        ]);

        try {
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
                        'ir_st_amount' => str_replace('.', '', $request->ir_st_amount),
                        'ir_st_status' => 1,
                        'ir_st_curr' => $request->curr,
                        'ir_nd_amount' => str_replace('.', '', $request->ir_nd_amount),
                        'ir_nd_status' => 1,
                        'ir_st_date' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'ir_nd_date' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'pa_limit' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(14)->format('Y-m-d'),
                        'now_update' => Carbon::now(),
                        'date_complete' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'professional_service' => str_replace('.', '', $request->professional_service)
                    ]);
                } else {
                    $caseList->update([
                        'ir_st_amount' => str_replace('.', '', $request->ir_st_amount),
                        'ir_nd_amount' => str_replace('.', '', $request->ir_nd_amount),
                        'ir_nd_curr' => $request->curr,
                        'ps_curr' => $request->curr,
                        'now_update' => Carbon::now(),
                        'date_complete' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'professional_service' => str_replace('.', '', $request->professional_service)
                    ]);
                }
            } else {
                if ($caseList->pa_status == 0) {
                    $caseList->update([
                        'pa_amount' => $request->pa_amount,
                        'pa_status' => 1,
                        'pa_curr' => $request->curr,
                        'pa_date' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'fr_limit' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(7)->format('Y-m-d'),
                        'now_update' => Carbon::now(),
                    ]);
                } else {
                    $caseList->update([
                        'pa_date' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                        'fr_limit' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(7)->format('Y-m-d'),
                        'now_update' => Carbon::now(),
                        'pa_amount' => $request->pa_amount,
                        'pa_curr' => $request->curr,
                    ]);
                }
            }

            return back()->with('success', 'Report tiga has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportTiga  $reportTiga
     * @return \Illuminate\Http\Response
     */
    public function show(ReportTiga $reportTiga)
    {
        $file = explode('.', $reportTiga->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportTiga->file_upload);
        } else {
            return Storage::download($reportTiga->file_upload);
        }
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
        $file = explode('.', $reportTiga->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($reportTiga->file_upload);
        } else {
            Storage::delete($reportTiga->file_upload);
        }

        $reportTiga->delete();

        return back()->with('success', 'File Report 4 has been deleted');
    }
}
