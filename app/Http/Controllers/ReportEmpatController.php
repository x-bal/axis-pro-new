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
        $attr = $request->validate([
            'case_list_id' => 'required',
            'file_upload' => 'required|max:10240',
            'time_upload' => 'required',
        ]);

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
                    'pa_amount' => $request->pa_amount,
                    'pa_status' => 1,
                    'fr_limit' => Carbon::now()->addDay(7),
                    'pa_date' => Carbon::now(),
                    'now_update' => Carbon::now(),
                    'file_status_id' => 2
                ]);
            } else {
                $caseList->update([
                    'pa_amount' => $request->pa_amount,
                    'now_update' => Carbon::now(),
                ]);
            }
        } else {
            if ($caseList->fr_status == 0) {
                $caseList->update([
                    'fr_amount' => $request->fr_amount,
                    'claim_amount' => $request->claim_amount,
                    'fr_status' => 1,
                    'fr_date' => Carbon::now(),
                    'now_update' => Carbon::now(),
                    'file_status_id' => 5
                ]);

                // if (\LaravelGmail::check()) {
                //     $messages = \LaravelGmail::message()->in($box = $caseList->file_no)->preload()->all();

                //     foreach ($messages as $message) {
                //         $label = $message->getLabels();

                //         $gmail = Gmail::create([
                //             'adjuster_id' => $caseList->adjuster_id,
                //             'caselist_id' => $caseList->id,
                //             'message_id' => $message->getId(),
                //             'subject' => $message->getSubject(),
                //             'label' => $label[0],
                //             'content' => $message->getHtmlBody()
                //         ]);

                //         foreach ($message->getAttachments() as $attachment) {
                //             $attachment->saveAttachmentTo($path = 'attachment', $filename = $attachment->filename, $disk = 'public');

                //             Attachment::create([
                //                 'gmail_id' => $gmail->id,
                //                 'filename' => $attachment->filename,
                //                 'file_url' => 'attachment/' . $attachment->filename
                //             ]);
                //         }
                //     }
                // }
            } else {
                $caseList->update([
                    'claim_amount' => $request->fr_amount,
                    'fr_amount' => $request->claim_amount,
                    'now_update' => Carbon::now(),
                ]);
            }
        }


        return back()->with('success', 'Report empat has been uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReportEmpat  $reportEmpat
     * @return \Illuminate\Http\Response
     */
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
}
