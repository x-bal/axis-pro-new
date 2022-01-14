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
        $request->validate([
            'case_list_id' => 'required',
            'file_upload' => 'required|max:20480',
            'file_upload.*' => 'max:20480|mimes:xlsx,xls,docx,doc,pdf,mp4',
            'time_upload' => 'required',
        ]);


        try {
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

            return back()->with('success', 'Report lima has been uploaded');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
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
        $file = explode('.', $reportLima->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($reportLima->file_upload);
        } else {
            Storage::delete($reportLima->file_upload);
        }

        $reportLima->delete();

        return back()->with('success', 'File Report 5 has been deleted');
    }
}
