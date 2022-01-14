<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\CaseList;
use App\Models\Gmail;
use App\Models\ReportEmpat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ReportEmpatController extends Controller
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
            // 'fr_date' => 'required',
        ]);

        try {

            if ($request->hasFile('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $file) {
                    $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                    $filename = 'files/report-empat/' . $name;
                    $path = 'files/report-empat/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
                    } else {
                        $file->storeAs('files/report-empat/', $name);
                    }

                    ReportEmpat::create([
                        'case_list_id' => $request->case_list_id,
                        'file_upload' => $filename,
                        'time_upload' => Carbon::now()
                    ]);
                }
            }

            $caseList = CaseList::find($request->case_list_id);

            if ($caseList->ir_status == 1) {
                if ($caseList->pa_status == 0) {
                    $caseList->update([
                        'pa_amount' => str_replace('.', '', $request->pa_amount),
                        'pa_status' => 1,
                        'pa_curr' => $request->curr,
                        'fr_limit' => Carbon::createFromFormat('d/m/Y', $request->pa_date)->addDay(7)->format('Y-m-d'),
                        'pa_date' => Carbon::createFromFormat('d/m/Y', $request->pa_date)->format('Y-m-d'),
                        'now_update' => Carbon::now(),
                        'file_status_id' => 2
                    ]);
                } else {
                    $caseList->update([
                        'fr_limit' => Carbon::createFromFormat('d/m/Y', $request->pa_date)->addDay(7)->format('Y-m-d'),
                        'pa_date' => Carbon::createFromFormat('d/m/Y', $request->pa_date)->format('Y-m-d'),
                        'pa_amount' => str_replace('.', '', $request->pa_amount),
                        'now_update' => Carbon::now(),
                        'pa_curr' => $request->curr,
                    ]);
                }
            } else {
                if ($caseList->fr_status == 0) {
                    $caseList->update([
                        'fr_amount' => str_replace('.', '', $request->fr_amount),
                        'claim_amount' => str_replace('.', '', $request->claim_amount),
                        'fr_status' => 1,
                        'fr_curr' => $request->curr,
                        'claim_amount_curr' => $request->claim_curr,
                        'fr_date' => Carbon::createFromFormat('d/m/Y', $request->fr_date)->format('Y-m-d'),
                        'now_update' => Carbon::now(),
                        'file_status_id' => 5
                    ]);

                    if (\LaravelGmail::check()) {
                        $messages = \LaravelGmail::message()->in($box = $caseList->file_no)->preload()->all();

                        foreach ($messages as $message) {
                            $label = $message->getLabels();

                            $gmail = Gmail::create([
                                'adjuster_id' => $caseList->adjuster_id,
                                'caselist_id' => $caseList->id,
                                'message_id' => $message->getId(),
                                'subject' => $message->getSubject(),
                                'label' => $label[0],
                                'content' => $message->getHtmlBody()
                            ]);

                            foreach ($message->getAttachments() as $attachment) {
                                $attachment->saveAttachmentTo($path = 'attachment', $filename = $attachment->filename, $disk = 'public');

                                Attachment::create([
                                    'gmail_id' => $gmail->id,
                                    'filename' => $attachment->filename,
                                    'file_url' => 'attachment/' . $attachment->filename
                                ]);
                            }
                        }
                    }
                } else {
                    $caseList->update([
                        'fr_amount' => str_replace('.', '', $request->fr_amount),
                        'fr_curr' => $request->curr,
                        'claim_amount_curr' => $request->claim_curr,
                        'claim_amount' => str_replace('.', '', $request->claim_amount),
                        'now_update' => Carbon::now(),
                    ]);
                }
            }

            return back()->with('success', 'Report empat has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(ReportEmpat $reportEmpat)
    {
        $file = explode('.', $reportEmpat->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportEmpat->file_upload);
        } else {
            return Storage::download($reportEmpat->file_upload);
        }
        return Storage::download($reportEmpat->file_upload);
    }

    public function destroy(ReportEmpat $reportEmpat)
    {
        $file = explode('.', $reportEmpat->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($reportEmpat->file_upload);
        } else {
            Storage::delete($reportEmpat->file_upload);
        }

        $reportEmpat->delete();

        return back()->with('success', 'File Report 4 has been deleted');
    }
}
