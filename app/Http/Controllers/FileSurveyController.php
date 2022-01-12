<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\FileSurvey;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Image;

class FileSurveyController extends Controller
{
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
                    $filename = 'files/file-survey/' . $name;
                    $path = 'files/file-survey/' . $name;

                    if (in_array($file->extension(), ['jpeg', 'jpg', 'png'])) {
                        \Image::make($file)->resize(480, 360)->save($path, 90);
                    } else {
                        $file->storeAs('files/file-survey/', $name);
                    }

                    FileSurvey::create([
                        'case_list_id' => $request->case_list_id,
                        'file_upload' => $filename,
                        'time_upload' => Carbon::now()
                    ]);
                }
            }

            CaseList::find($request->case_list_id);

            return back()->with('success', 'File survey has been uploaded');
        } catch (Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }

    public function show(FileSurvey $fileSurvey)
    {
        $file = explode('.', $fileSurvey->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return  Response::download($fileSurvey->file_upload);
        } else {
            return Storage::download($fileSurvey->file_upload);
        }
    }

    public function destroy(FileSurvey $fileSurvey)
    {
        $file = explode('.', $fileSurvey->file_upload);
        $ext = $file[1];

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            File::delete($fileSurvey->file_upload);
        } else {
            Storage::delete($fileSurvey->file_upload);
        }

        $fileSurvey->delete();

        return back()->with('success', 'File Survey has been deleted');
    }
}
