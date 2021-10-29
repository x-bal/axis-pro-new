<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CaseList;
use App\Models\Gmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GmailController extends Controller
{
    public function show($id, CaseList $caseList)
    {
        $mail = Gmail::with('attachments')->find($id);
        if ($mail == null) {
            $gmail = \LaravelGmail::message()->get($id);
        } else {
            $gmail = $mail;
        }
        // $caseList = CaseList::with('insurance')->find($caseList->id);

        return view('gmail.show', compact('gmail', 'mail', 'caseList'));
    }
    public function makeToken()
    {
        \LaravelGmail::makeToken();
        $email = \LaravelGmail::user();

        $user = User::where('email', $email)->first();

        if (Auth::loginUsingId($user->id)) {
            return redirect('/dashboard');
        } else {
            Auth::logout();
            \LaravelGmail::logout();
            return back();
        }
    }

    public function download($id)
    {
        $file = 'attachment/' . $id;
        return Storage::download($file);
    }

    public function logout()
    {
        Auth::logout();
        \LaravelGmail::logout();

        return redirect('/');
    }
}
