<?php

namespace App\Http\Controllers;

use App\Exports\CaseListExport;
use App\Models\{CaseList, User, Broker, Incident, Policy, Client, Currency, Expense, FileStatus, Invoice, MemberInsurance};
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class CaseListController extends Controller
{
    public function index()
    {
        Gate::allows(abort_unless('case-list-access', 403));

        if (auth()->user()->hasRole('admin')) {
            $data = CaseList::orderBy('file_no', 'desc')->get();
        } else {
            $data = CaseList::orderBy('file_no', 'desc')->where('adjuster_id', auth()->user()->id)->get();
        }

        if (request()->ajax()) {

            return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('fileno', function ($row) {
                    return '<a href="' . route('case-list.show', $row->id) . '">' . $row->file_no . '</a>';
                })
                ->editColumn('initial', function ($row) {
                    return $row->adjuster->kode_adjuster;
                })
                ->editColumn('name', function ($row) {
                    return $row->insurance->name;
                })
                ->editColumn('share', function ($row) {
                    foreach ($row->member as $member) {
                        return $member->share . '%';
                    }
                })
                ->editColumn('is_leader', function ($row) {
                    $html = '
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample' . $row->id . '"
                      aria-expanded="false" aria-controls="collapseExample' . $row->id . '">
                      &plus;
                    </button>
                    <div class="collapse" id="collapseExample' . $row->id . '">
                        <div class="mt-3">
                        <ul class="list-unstyled">
                        ';
                    foreach ($row->member as $data) {
                        $html .= '<li>' . $data->client->brand . '-' . '(' . $data->share . ')' . '-' . '<strong>' . $data->is_leader . '</strong>' . '<li>';
                    };
                    $html .= '
                        </ul>
                        </div>
                    </div>
                    ';
                    return $html;
                    foreach ($row->member as $member) {
                        return $member->is_leader == 1 ? 'Leader' : 'Member';
                    }
                })
                ->editColumn('leader', function ($row) {
                    foreach ($row->member as $member) {
                        return $member->is_leader == 1 ? Client::find($member->member_insurance)->name ?? '-' : '-';
                    }
                })
                ->editColumn('cause', function ($row) {
                    return $row->incident->type_incident;
                })
                ->editColumn('status', function ($row) {
                    return $row->status->nama_status;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<div class="btn-group"><a href="/case-list/' . $row->id . '/edit" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                    <form method="post" action="' . route('case-list.destroy', $row->id) . '">
                    ' . csrf_field() . method_field('delete') . '
                    <button type="submit" onclick="return confirm(`Anda Yakin Ingin Menghapus Data Case List?`)" class="btn btn-sm btn-danger"><i class="fab fa-bitbucket"></i></button>
                    </form>
                     </div>';
                    //     $btn .= "<form action='' method='post' style='display: inline;'>
                    //     <button type='submit' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></button>
                    // </form>";

                    return $btn;
                })
                // ->filter(function ($instance) {
                //     if (request()->has('status')) {
                //         $instance->where('file_status_id', request('status'));
                //     }
                // })
                ->rawColumns(['action', 'fileno', 'is_leader'])
                ->make(true);
        }



        if (auth()->user()->hasRole('admin')) {
            $adjuster = User::whereHas('roles', function ($qr) {
                return $qr->where('name', 'Adjuster');
            })->get();
            return view('case-list.index', compact('adjuster'));
        } else {
            $status = FileStatus::get();
            return view('case-list.index', compact('status'));
        }
    }

    public function create()
    {
        Gate::allows(abort_unless('case-list-create', 403));

        return view('case-list.create', [
            'caseList' => new Caselist(),
            'client' => Client::get(),
            'user' => User::role('adjuster')->get(),
            'broker' => Broker::get(),
            'incident' => Incident::get(),
            'policy' => Policy::get(),
            'file_no' => Caselist::pluck('file_no')
        ]);
    }

    public function store(Request $request)
    {
        Gate::allows(abort_unless('case-list-create', 403));

        $this->validate($request, [
            'file_no' => 'required|unique:case_lists',
            'risk_location' => 'required',
            // 'leader' => 'required',
            'begin' => 'required',
            'end' => 'required',
            'dol' => 'required',
            'insured' => 'required',
            'insurance' => 'required',
            'adjuster' => 'required',
            'category' => 'required',
            'currency' => 'required',
            'broker' => 'required',
            'incident' => 'required',
            'policy' => 'required',
            'no_leader_policy' => 'required',
            'instruction_date' => 'required',
            'leader_claim_no' => 'required',
            'survey_date' => 'required',
            'member' => 'required|array|min:1',
            'percent' => 'required|array|min:1',
            'status' => 'required|array|min:1'
        ]);
        if (!(array_sum($request->percent) <= 100 and array_sum($request->percent) >= 100)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'percent' => ['Total Member Share Harus 100, Total Yang Di Input : '.array_sum($request->percent)],
            ]);
            throw $error;
        }
        // $amount = str_replace(',', '', $request->amount);
        // $claim_amount = str_replace(',', '', $request->claim_amount);
        if (strlen($request->file_no) == 6) {
            try {
                DB::beginTransaction();
                $caselist = Caselist::create([
                    'file_no' => $request->file_no . '-JAK',
                    'insurance_id' => $request->insurance,
                    'adjuster_id' => $request->adjuster,
                    'broker_id' => $request->broker,
                    'incident_id' => $request->incident,
                    'policy_id' => $request->policy,
                    'insured' => $request->insured,
                    'risk_location' => $request->risk_location,
                    'currency' => $request->currency,
                    'leader' => $request->insurance,
                    'begin' => $request->begin,
                    'end' => $request->end,
                    'dol' => $request->dol,
                    'category' => $request->category,
                    'no_leader_policy' => $request->no_leader_policy,
                    'instruction_date' => $request->instruction_date,
                    'leader_claim_no' => $request->leader_claim_no,
                    'file_status_id' => 1,
                    'survey_date' => $request->survey_date
                ]);
                for ($i = 1; $i <= count($request->member); $i++) {
                    MemberInsurance::create([
                        'file_no_outstanding' => $caselist->id,
                        'member_insurance' => $request->member[$i],
                        'share' => $request->percent[$i],
                        'is_leader' => $request->status[$i] == 'LEADER' ? 1 : 0,
                        'invoice_leader' => 1
                    ]);
                }
                DB::commit();
                return back()->with('success', 'Berhasil Membuat Data');
            } catch (Exception $th) {
                DB::rollBack();
                return back()->with('error', $th->getMessage());
            }
        } else {
            return back()->with('error', 'Kode CaseList Tidak Diterima');
        }
    }

    public function show(CaseList $caseList)
    {
        Gate::allows(abort_unless('case-list-show', 403));

        $status = FileStatus::get();
        return view('case-list.show', compact('caseList', 'status'));
    }

    public function getcase(CaseList $caseList)
    {
        $caseList = CaseList::with('');
    }

    public function edit(CaseList $caseList)
    {
        Gate::allows(abort_unless('case-list-edit', 403));

        return view('case-list.edit', [
            'caseList' => $caseList,
            'client' => Client::get(),
            'user' => User::role('adjuster')->get(),
            'broker' => Broker::get(),
            'incident' => Incident::get(),
            'policy' => Policy::get(),
            'file_no' => Caselist::pluck('file_no')
        ]);
    }
    public function update(Request $request, CaseList $caseList)
    {
        Gate::allows(abort_unless('case-list-edit', 403));

        if ($request->currency != $caseList->currency) {

            $currency = Currency::get()->firstOrFail();
            try {
                DB::beginTransaction();
                $caseList =  CaseList::where('id', $caseList->id)->first();
                if ($request->currency == 'RP') {
                    if ($caseList->ir_status == 1) {
                        $caseList->update([
                            'ia_amount' => strval(round($caseList->ia_amount * $currency->kurs)),
                            'pr_amount' => strval(round($caseList->pr_amount * $currency->kurs)),
                            'ir_st_amount' => strval(round($caseList->ir_st_amount * $currency->kurs)),
                            'pa_amount' => strval(round($caseList->pa_amount * $currency->kurs)),
                            'fr_amount' => strval(round($caseList->fr_amount * $currency->kurs)),
                            'claim_amount' => strval(round($caseList->claim_amount * $currency->kurs))
                        ]);
                    } else {
                        $caseList->update([
                            'ia_amount' => strval(round($caseList->ia_amount * $currency->kurs)),
                            'pr_amount' => strval(round($caseList->pr_amount * $currency->kurs)),
                            'pa_amount' => strval(round($caseList->pa_amount * $currency->kurs)),
                            'fr_amount' => strval(round($caseList->fr_amount * $currency->kurs)),
                            'claim_amount' => strval(round($caseList->claim_amount * $currency->kurs))
                        ]);
                    }

                    foreach ($caseList->expense as $data) {
                        Expense::where('case_list_id', $caseList->id)->update([
                            'amount' => strval(round($data->amount * $currency->kurs))
                        ]);
                    }
                }

                if ($request->currency == 'USD') {
                    if ($caseList->ir_status == 1) {
                        $caseList->update([
                            'ia_amount' => strval(round($caseList->ia_amount / $currency->kurs, 2)),
                            'pr_amount' => strval(round($caseList->pr_amount / $currency->kurs, 2)),
                            'ir_st_amount' => strval(round($caseList->ir_st_amount / $currency->kurs, 2)),
                            'pa_amount' => strval(round($caseList->pa_amount / $currency->kurs, 2)),
                            'fr_amount' => strval(round($caseList->fr_amount / $currency->kurs, 2)),
                            'claim_amount' => strval(round($caseList->claim_amount / $currency->kurs, 2))
                        ]);
                    } else {
                        $caseList->update([
                            'ia_amount' => strval(round($caseList->ia_amount / $currency->kurs, 2)),
                            'pr_amount' => strval(round($caseList->pr_amount / $currency->kurs, 2)),
                            'pa_amount' => strval(round($caseList->pa_amount / $currency->kurs, 2)),
                            'fr_amount' => strval(round($caseList->fr_amount / $currency->kurs, 2)),
                            'claim_amount' => strval(round($caseList->claim_amount / $currency->kurs, 2))
                        ]);
                    }

                    foreach ($caseList->expense as $data) {
                        Expense::where('case_list_id', $caseList->id)->update([
                            'amount' => strval(round($data->amount / $currency->kurs, 2))
                        ]);
                    }
                }
                DB::commit();
            } catch (Exception $err) {
                DB::rollBack();
                return back()->with('error', $err->getMessage());
            }
        }
        try {
            $member = array_values($request->member);
            $share = array_values($request->percent);
            $status = array_values($request->status);
            // $amount = str_replace(',', '', $request->amount);
            // $claim_amount = str_replace(',', '', $request->claim_amount);
            DB::beginTransaction();
            $caseList->update([
                'file_no' => $request->file_no . '-JAK',
                'insurance_id' => $request->insurance,
                'adjuster_id' => $request->adjuster,
                'broker_id' => $request->broker,
                'incident_id' => $request->incident,
                'policy_id' => $request->policy,
                'insured' => $request->insured,
                'risk_location' => $request->risk_location,
                'currency' => $request->currency,
                'leader' => $request->insurance,
                'begin' => $request->begin,
                'end' => $request->end,
                'dol' => $request->dol,
                'category' => $request->category,
                'survey_date' => $request->survey_date
            ]);
            MemberInsurance::where('file_no_outstanding', $caseList->id)->delete();
            for ($i = 0; $i < count($request->member); $i++) {
                MemberInsurance::create([
                    'file_no_outstanding' => $caseList->id,
                    'member_insurance' => $member[$i],
                    'share' => $share[$i],
                    'is_leader' => $status[$i] == 'LEADER' ? 1 : 0,
                    'invoice_leader' => 1
                ]);
            }
            DB::commit();
            return redirect()->route('case-list.index')->with('success', 'Case list has been updated');
        } catch (Exception $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(CaseList $caseList)
    {
        Invoice::where('case_list_id', $caseList->id)->delete();
        $caseList->delete();
        return back()->with('success', "Delete Successfull");
    }

    public function status()
    {
        $caseList = CaseList::find(request('id'));
        $caseList->update([
            'file_status_id' => request('status'),
            'now_update' => Carbon::now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Case list current status has been updated'
        ], 200);
    }

    public function irstatus()
    {
        $caseList = CaseList::find(request('id'));

        if (request('status') == 0) {
            $caseList->update([
                'ir_status' => request('status'),
            ]);
        } else {
            $caseList->update([
                'ir_status' => request('status'),
                'ir_st_limit' => Carbon::parse($caseList->pr_date)->addDay(14)->format('Y-m-d'),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => $caseList->ir_status == 1 ? 'Interim report has been used' : 'Interim report has been removed',
            'case_list' => $caseList
        ], 200);
    }
    public function laporan(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $this->validate($request, [
                'from' => 'required',
                'to' => 'required',
                'adjuster' => 'required'
            ]);
        } else {
            $this->validate($request, [
                'from' => 'required',
                'to' => 'required',
                'status' => 'required'
            ]);
        }

        if (auth()->user()->hasRole('admin')) {

            $case = CaseList::whereBetween('instruction_date', [$request->from, $request->to])->where('adjuster_id', $request->adjuster)->get();


            $claim_amount_idr = $case->where('currency', 'RP')->sum('claim_amount');
            $claim_amount_usd = $case->where('currency', 'USD')->sum('claim_amount');
            $fee_idr = $case->where('currency', 'RP')->sum('fee_idr');
            $fee_usd = $case->where('currency', 'USD')->sum('fee_usd');

            if ($request->adjuster == "All") {

                $case =  CaseList::whereBetween('instruction_date', [$request->from, $request->to])->get();
                $claim_amount_idr = $case->where('currency', 'RP')->sum('claim_amount');
                $claim_amount_usd = $case->where('currency', 'USD')->sum('claim_amount');
                $fee_idr = $case->where('currency', 'RP')->sum('fee_idr');
                $fee_usd = $case->where('currency', 'USD')->sum('fee_usd');
            }
            return view('case-list.laporan', [
                'from' => $request->from,
                'to' => $request->to,
                'case' => $case,
                'adjuster' => $request->adjuster,
                'claim_amount_idr' => $claim_amount_idr,
                'claim_amount_usd' => $claim_amount_usd,
                'fee_idr' => $fee_idr,
                'fee_usd' => $fee_usd
            ]);
        } else {
            $case = CaseList::whereBetween('instruction_date', [$request->from, $request->to])->where('file_status_id', $request->status)->where('adjuster_id', auth()->user()->id)->get();


            $claim_amount_idr = $case->where('currency', 'RP')->sum('claim_amount');
            $claim_amount_usd = $case->where('currency', 'USD')->sum('claim_amount');
            $fee_idr = $case->where('currency', 'RP')->sum('fee_idr');
            $fee_usd = $case->where('currency', 'USD')->sum('fee_usd');

            if ($request->status == "All") {
                $case =  CaseList::whereBetween('instruction_date', [$request->from, $request->to])->where('adjuster_id', auth()->user()->id)->get();

                $claim_amount_idr = $case->where('currency', 'RP')->sum('claim_amount');
                $claim_amount_usd = $case->where('currency', 'USD')->sum('claim_amount');
                $fee_idr = $case->where('currency', 'RP')->sum('fee_idr');
                $fee_usd = $case->where('currency', 'USD')->sum('fee_usd');
            }
            return view('case-list.laporan', [
                'from' => $request->from,
                'to' => $request->to,
                'status' => $request->status,
                'case' => $case,
                'claim_amount_idr' => $claim_amount_idr,
                'claim_amount_usd' => $claim_amount_usd,
                'fee_idr' => $fee_idr,
                'fee_usd' => $fee_usd
            ]);
        }
    }
    public function excel(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $this->validate($request, [
                'from' => 'required',
                'to' => 'required',
                'adjuster' => 'required'
            ]);
        } else {
            $this->validate($request, [
                'from' => 'required',
                'to' => 'required',
                'status' => 'required'
            ]);
        }

        // ob_end_clean();
        // ob_start();
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        return Excel::download(new CaseListExport($request->except(['_token'])), 'Case List ' . $timestamp . ' Report.xlsx');
    }

    public function invoice($id)
    {
        $case = CaseList::find($id);
        $amount = 0;

        foreach ($case->expense as $expense) {
            $amount += $expense->amount;
        }

        if ($amount > 0) {
            $case->update([
                'is_ready' => 1
            ]);

            return back()->with('success', 'Your case is ready to generate invoice');
        } else {
            return back()->with('error', 'Your expense is empty');
        }
    }

    public function restore()
    {
        Invoice::onlyTrashed()->restore();
        CaseList::onlyTrashed()->restore();
        return back()->with('success', 'Restore Successfull');
    }
}
