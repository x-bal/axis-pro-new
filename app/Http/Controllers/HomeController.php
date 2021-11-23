<?php

namespace App\Http\Controllers;

use App\Models\CaseList;
use App\Models\Currency;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $satu = CaseList::where('ia_status', 0)->where('remark', NULL)->count();
            $dua = CaseList::where('ia_status', 1)->where('pr_status', 0)->where('remark', NULL)->count();
            $tiga = CaseList::where('pa_status', 0)->where('pr_status', 1)->where('remark', NULL)->count();
            $empat = CaseList::where('fr_status', 0)->where('pa_status', 1)->where('remark', NULL)->count();
            $lima = CaseList::where('fr_status', 0)->where('ir_st_status', 1)->where('pa_status', 1)->where('remark', NULL)->count();
        } else {
            $satu = CaseList::where('adjuster_id', auth()->user()->id)->where('ia_status', 0)->where('remark', NULL)->count();
            $dua = CaseList::where('adjuster_id', auth()->user()->id)->where('ia_status', 1)->where('pr_status', 0)->where('remark', NULL)->count();
            $tiga = CaseList::where('adjuster_id', auth()->user()->id)->where('pa_status', 0)->where('pr_status', 1)->where('remark', NULL)->count();
            $empat = CaseList::where('adjuster_id', auth()->user()->id)->where('fr_status', 0)->where('pa_status', 1)->where('remark', NULL)->count();
            $lima = CaseList::where('adjuster_id', auth()->user()->id)->where('fr_status', 0)->where('ir_st_status', 1)->where('pa_status', 1)->where('remark', NULL)->count();
        }

        return view('dashboard.index', compact('satu', 'dua', 'tiga', 'empat', 'lima'));
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        $kurs = Currency::first();
        return view('dashboard.profile', compact('user', 'kurs'));
    }

    public function update(Request $request, User $user)
    {
        $attr = $request->validate([
            'nama_lengkap' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($request->password != null) {
            $attr['password'] = Hash::make($request->password);
        } else {
            $attr['password'] = $user->password;
        }

        $user->update($attr);

        return back()->with('success', 'Your profile has been updated');
    }

    public function report($report)
    {
        if ($report == 1) {
            $title = 'Report Satu';

            if (auth()->user()->hasRole('admin')) {
                $cases = CaseList::where('ia_status', 0)->get();
            } else {
                $cases = CaseList::where('ia_status', 0)->where('adjuster_id', auth()->user()->id)->get();
            }
        }

        if ($report == 2) {
            $title = 'Report Dua';

            if (auth()->user()->hasRole('admin')) {
                $cases = CaseList::where('ia_status', 1)->where('pr_status', 0)->get();
            } else {
                $cases = CaseList::where('ia_status', 1)->where('pr_status', 0)->where('adjuster_id', auth()->user()->id)->get();
            }
        }

        if ($report == 3) {
            $title = 'Report Tiga';

            if (auth()->user()->hasRole('admin')) {
                $cases = CaseList::where('pa_status', 0)->where('pr_status', 1)->get();
            } else {
                $cases = CaseList::where('pa_status', 0)->where('pr_status', 1)->where('adjuster_id', auth()->user()->id)->get();
            }
        }

        if ($report == 4) {
            $title = 'Report Empat';

            if (auth()->user()->hasRole('admin')) {
                $cases = CaseList::where('fr_status', 0)->where('pa_status', 1)->get();
            } else {
                $cases = CaseList::where('fr_status', 0)->where('pa_status', 1)->where('adjuster_id', auth()->user()->id)->get();
            }
        }

        if ($report == 5) {
            $title = 'Report Lima';

            if (auth()->user()->hasRole('admin')) {
                $cases = CaseList::where('fr_status', 0)->where('ir_st_status', 1)->where('pa_status', 1)->get();
            } else {
                $cases = CaseList::where('fr_status', 0)->where('ir_st_status', 1)->where('pa_status', 1)->where('adjuster_id', auth()->user()->id)->get();
            }
        }

        return view('dashboard.report', compact('cases', 'title'));
    }
}
