<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\ReportDua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ReportDuaController extends Controller
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
            'file_upload.*' => 'required|max:20480',
            'file_upload.*' => 'max:20480|mimes:xlsx,xls,docx,doc,pdf,mp4',
            'time_upload' => 'required',
            'pr_amount' => 'required',
            'ir_status' => 'required',
            'date_complete' => 'required',
        ]);


        try {

            if ($request->hasFile('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $file) {
                    $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                    $filename = 'files/report-dua/' . $name;
                    $path = 'files/report-dua/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
                    } else {
                        $file->storeAs('files/report-dua/', $name);
                    }

                    ReportDua::create([
                        'case_list_id' => $request->case_list_id,
                        'file_upload' => $filename,
                        'time_upload' => Carbon::now()
                    ]);
                }
            }

            $caseList = CaseList::find($request->case_list_id);
            $update = [
                'pr_amount' => str_replace('.', '', $request->pr_amount),
                'pr_status' => 1,
                'pr_curr' => $request->curr,
                'pr_date' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d'),
                'now_update' => Carbon::now(),
                'ir_status' => $request->ir_status,
                'file_status_id' => 4
            ];

            if ($caseList->pr_status == 0) {
                if ($request->ir_status == 0) {
                    $update['pa_limit'] = Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(14)->format('Y-m-d');
                    $caseList->update($update);
                } else {
                    $update['ir_st_limit'] = Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(14)->format('Y-m-d');
                    $caseList->update($update);
                }
            } else {
                if ($request->ir_status == 0) {
                    $update['pa_limit'] = Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(14)->format('Y-m-d');
                    $caseList->update($update);
                } else {
                    $update['ir_st_limit'] = Carbon::createFromFormat('d/m/Y', $request->date_complete)->addDay(14)->format('Y-m-d');
                    $caseList->update($update);
                }

                $caseList->update([
                    'pr_amount' => str_replace('.', '', $request->pr_amount),
                    'pr_curr' => $request->curr,
                    'date_complete' => Carbon::createFromFormat('d/m/Y', $request->date_complete)->format('Y-m-d')
                ]);
            }

            return back()->with('success', 'Report dua has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(ReportDua $reportDua)
    {
        $file = explode('.', $reportDua->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportDua->file_upload);
        } else {
            return Storage::download($reportDua->file_upload);
        }
    }

    public function edit(ReportDua $reportDua)
    {
        //
    }

    public function update(Request $request, ReportDua $reportDua)
    {
        //
    }

    public function destroy(ReportDua $reportDua)
    {
        $file = explode('.', $reportDua->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($reportDua->file_upload);
        } else {
            Storage::delete($reportDua->file_upload);
        }

        $reportDua->delete();

        return back()->with('success', 'File Report 2 has been deleted');
    }
}
