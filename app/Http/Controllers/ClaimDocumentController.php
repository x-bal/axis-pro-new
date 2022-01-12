<?php

namespace App\Http\Controllers;

use App\Models\ClaimDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ClaimDocumentController extends Controller
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
            'file_upload' => 'required',
            'file_upload.*' => 'max:20480|mimes:xlsx,xls,docx,doc,pdf,mp4',
            'time_upload' => 'required',
        ]);

        try {
            if ($request->hasFile('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $file) {
                    $name = date('dmYHis')  . '-' . $file->getClientOriginalName();
                    $filename = 'files/claim-document/' . $name;
                    $path = 'files/claim-document/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
                    } else {
                        $file->storeAs('files/claim-document', $name);
                    }

                    ClaimDocument::create([
                        'case_list_id' => $request->case_list_id,
                        'file_upload' => $filename,
                        'time_upload' => Carbon::now()
                    ]);
                }
            }
            return back()->with('success', 'Claim document has been uploaded');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClaimDocument  $claimDocument
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimDocument $claimDocument)
    {
        $file = explode('.', $claimDocument->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($claimDocument->file_upload);
        } else {
            return Storage::download($claimDocument->file_upload);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClaimDocument  $claimDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(ClaimDocument $claimDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClaimDocument  $claimDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClaimDocument $claimDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClaimDocument  $claimDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClaimDocument $claimDocument)
    {
        $file = explode('.', $claimDocument->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            \File::delete($claimDocument->file_upload);
        } else {
            Storage::delete($claimDocument->file_upload);
        }

        $claimDocument->delete();

        return back()->with('success', 'File Claim Document has been deleted');
    }
}
