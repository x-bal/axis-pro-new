<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\CaseList;
use App\Models\Gmail;
use App\Models\ReportLima;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
            'file_upload' => 'required|max:10240',
            'time_upload' => 'required',
        ]);

        if ($request->hasFile('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $file) {
                $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                $filename = 'files/report-lima/' . $name;
                $path = 'files/report-lima/' . $name;

                if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                    \Image::make($file)->resize(480, 360)->save($path, 90);
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
        $file = explode('.', $reportLima->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($reportLima->file_upload);
        } else {
            return Storage::download($reportLima->file_upload);
        }
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
