<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\CaseList;
use App\Models\Client;
use App\Models\FeeBased;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Policy;
use Dotenv\Validator;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AjaxController extends Controller
{
    public function TheAutoCompleteFunc(Request $request)
    {
        $data = [];
        $caseList = CaseList::where('file_no', 'like', '%' . $request->q . '%')->where('is_ready', 2)->get();
        foreach ($caseList as $row) {
            $data[] = ['id' => $row->id, 'text' => $row->file_no];
        }
        return response()->json($data);
    }
    public function insurance($id)
    {
        return response()->json(Client::findOrFail($id));
    }
    public function currency()
    {
        $response = Currency::first();
        return response()->json($response);
    }
    public function caselist($id)
    {
        try {
            $caselist = CaseList::find($id);
            // 1
            if ($caselist->category == 1) {
                $feebased = FeeBased::where('category_fee', 1)->get();
                if ($caselist->currency == 'IDR') {
                    $max = FeeBased::where('category_fee', 1)->max('adjusted_idr');
                    foreach ($feebased as $data) {
                        if ($caselist->claim_amount <= $data->adjusted_idr) {
                            $array = [
                                'adjusted' => $data->adjusted_idr,
                                'claim_amount' => $caselist->claim_amount,
                                'fee' => $data->fee_idr
                            ];
                            break;
                        }
                    }
                    if ($caselist->claim_amount > $max) {
                        $array = [
                            'adjusted' => $max,
                            'claim_amount' => $caselist->claim_amount,
                            'fee' => $caselist->claim_amount * 2 / 100
                        ];
                    }
                }
                if ($caselist->currency == 'USD') {
                    $max = FeeBased::where('category_fee', 1)->max('adjusted_usd');
                    foreach ($feebased as $data) {
                        if ($caselist->claim_amount <= $data->adjusted_usd) {
                            $array = [
                                'adjusted' => $data->adjusted_usd,
                                'claim_amount' => $caselist->claim_amount,
                                'fee' => $data->fee_usd
                            ];
                            break;
                        }
                    }
                    if ($caselist->claim_amount > $max) {
                        $array = [
                            'adjusted' => $max,
                            'claim_amount' => $caselist->claim_amount,
                            'fee' => $caselist->claim_amount * 2 / 100
                        ];
                    }
                }
            }
            // 2
            if ($caselist->category == 2) {
                $feebased = FeeBased::where('category_fee', 2)->get();
                if ($caselist->currency == 'IDR') {
                    $max = FeeBased::where('category_fee', 2)->max('adjusted_idr');
                    foreach ($feebased as $data) {
                        if ($caselist->claim_amount <= $data->adjusted_idr) {
                            $array = [
                                'adjusted' => $data->adjusted_idr,
                                'claim_amount' => $caselist->claim_amount,
                                'fee' => $data->fee_idr
                            ];
                            break;
                        }
                    }
                    if ($caselist->claim_amount > $max) {
                        $array = [
                            'adjusted' => $max,
                            'claim_amount' => $caselist->claim_amount,
                            'fee' => $caselist->claim_amount * 2 / 100
                        ];
                    }
                }
                if ($caselist->currency == 'USD') {
                    $max = FeeBased::where('category_fee', 2)->max('adjusted_usd');
                    foreach ($feebased as $data) {
                        if ($caselist->claim_amount <= $data->adjusted_usd) {
                            $array = [
                                'adjusted' => $data->adjusted_usd,
                                'claim_amount' => $caselist->claim_amount,
                                'fee' => $data->fee_usd
                            ];
                            break;
                        }
                        if ($caselist->claim_amount > $max) {
                            $array = [
                                'adjusted' => $max,
                                'claim_amount' => $caselist->claim_amount,
                                'fee' => $caselist->claim_amount * 2 / 100
                            ];
                            break;
                        }
                    }
                }
            }
            $interim = 0;
            if($caselist->ir_status){
                $interim = $caselist->invoice->where('type_invoice', 1)->sum('grand_total');
            }
            $response = [
                'caselist' => CaseList::with('member', 'expense', 'insurance')->where('id', $id)->firstOrFail(),
                'expense' => $caselist->expense()->sum('total'  ),
                'sum' => $array,
                'interim' => $interim
            ];

            return response()->json($response);
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
    public function ChartCaseList()
    {

        $caselist = CaseList::where('instruction_date', '>', Carbon::now()->subMonths(6))->with('policy')->get();
        $policy = Policy::get();
        $response = [
            'caselist' => $caselist,
            'policy' => $policy
        ];
        return response()->json($response);
    }
    public function count($id)
    {
        $policy = Policy::find($id)->caselist->count();
        return $policy;
    }
    public function invoice(Request $request)
    {
        $attr = $request->all();
        $response = Invoice::find($attr['id'])->update([
            'bank_id' => $attr['bank'],
            'status_paid' => $attr['status'],
            'tanggal_invoice' => $attr['tanggal_invoice']
        ]);
        return response()->json($response);
    }
    public function kurs(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'kurs' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag());
        }
        if (Currency::first() == null) {
            Currency::create([
                'kurs' => $request->kurs
            ]);
        } else {
            Currency::first()->update([
                'kurs' => $request->kurs
            ]);
        }
        return response()->json($request->kurs);
    }
    public function ChartLineCaseList($id)
    {
        $user = User::find($id);
        if ($user->hasRole('admin')) {
            $bulan = [
                CaseList::whereMonth('instruction_date', '01')->get()->count(),
                CaseList::whereMonth('instruction_date', '02')->get()->count(),
                CaseList::whereMonth('instruction_date', '03')->get()->count(),
                CaseList::whereMonth('instruction_date', '04')->get()->count(),
                CaseList::whereMonth('instruction_date', '05')->get()->count(),
                CaseList::whereMonth('instruction_date', '06')->get()->count(),
                CaseList::whereMonth('instruction_date', '07')->get()->count(),
                CaseList::whereMonth('instruction_date', '08')->get()->count(),
                CaseList::whereMonth('instruction_date', '09')->get()->count(),
                CaseList::whereMonth('instruction_date', '10')->get()->count(),
                CaseList::whereMonth('instruction_date', '11')->get()->count(),
                CaseList::whereMonth('instruction_date', '12')->get()->count(),
            ];
        } else {
            $bulan = [
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '01')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '02')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '03')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '04')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '05')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '06')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '07')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '08')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '09')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '10')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '11')->get()->count(),
                CaseList::where('adjuster_id', $user->id)->whereMonth('instruction_date', '12')->get()->count(),
            ];
        }
        return response()->json($bulan);
    }
    public function CaseListFileNoLast()
    {
        try {
            $resource = CaseList::withTrashed()->get();
            $wallet = [];
            foreach ($resource as $data) {
                array_push($wallet, str_replace('-JAK', '', $data->file_no));
            }
            array_multisort($wallet);
            $response = end($wallet);
            $response += 1;
            $response = str_pad($response, 6, '0', STR_PAD_LEFT);
            return response()->json($response);
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
    public function CaseListFileNoEdit($id)
    {
        try {
            $case = CaseList::findOrFail($id);
            $response =  $case->file_no;
            $response = str_replace('-JAK', '', $response);
            $response = str_pad($response, 6, '0', STR_PAD_LEFT);
            return response()->json($response);
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
    public function TheAutoCompleteFuncIterim(Request $request)
    {
        $data = [];
        $caseList = CaseList::where('file_no', 'like', '%' . $request->q . '%')->where('is_ready', 1)->get();
        foreach ($caseList as $row) {
            $data[] = ['id' => $row->id, 'text' => $row->file_no];
        }
        return response()->json($data);
    }
    public function GetInterimResource($id)
    {
        $caselist = CaseList::with('insurance')->find($id);
        try{
            $response = [
                'caselist' => CaseList::with('member', 'expense', 'insurance')->where('id', $id)->firstOrFail(),
                'expense' => $caselist->expense()->sum('total')
            ];
            return response()->json($response);
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
}
