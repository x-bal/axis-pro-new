<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\Bank;
use App\Models\CaseList;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\MemberInsurance;
use App\Models\NoInvoice;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index', [
            'invoice' => Invoice::whereHas('caselist')->get(),
            'member' => MemberInsurance::get(),
            'caselist' => CaseList::get(),
            'bank' => Bank::get()
        ]);
    }

    public function create()
    {
        //
    }

    public function storeInterim(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'date_invoice' => 'required',
            'no_invoice.*' => 'required',
        ]);

        try {

            if ($request->no_invoice == null) {
                return back()->with('error', 'Member Invoice Does not Exists');
            }

            if (CaseList::find($request->no_case_interim)->hasInvoice()) {
                return back()->with('error', 'invoiced is already exists');
            }

            DB::beginTransaction();
            $fee_based = str_replace(',', '', $request->fee_based);
            $fee_based = intval($fee_based);
            $caselist = CaseList::find($request->no_case_interim);

            $total = str_replace(',', '', $request->total);
            $total = intval($total);

            foreach (CaseList::find($request->no_case_interim)->member as $key => $data) {
                Invoice::create([
                    'case_list_id' => $request->no_case_interim,
                    'member_id' => $data->member_insurance,
                    'no_invoice' => $request->no_invoice[$key],
                    'date_invoice' => Carbon::createFromFormat('d/m/Y', $request->date_invoice)->format('Y-m-d'),
                    'due_date' => Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->date_invoice)->format('Y-m-d'))->addDays(30)->format('Y-m-d'),
                    'status_paid' => 0,
                    'bank_id' => 1,
                    'is_active' => 1,
                    'type_invoice' => 1,
                    'grand_total' => $total * $data->share / 100
                ]);
            }

            $expenses = Expense::where('case_list_id', $caselist->id)->get();

            foreach ($expenses as $expense) {
                $expense->update(['is_active' => 1]);
            }
            // if ($request->type == 1) {
            //     $caselist->update(['discount' => $request->discount]);
            // } else {
            //     $caselist->update(['discount_percent' => $request->discount]);
            // }

            DB::commit();
            return back()->with('success', 'Success create Invoice');
        } catch (Exception $err) {
            DB::rollBack();
            return back()->with('error', $err->getMessage());
        }
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'fee_based' => 'required',
            'date_invoice' => 'required',
            'no_invoice.*' => 'required',
            'type_invoice' => 'required',
        ]);
        if ($request->no_invoice == null) {
            return back()->with('error', 'Member Invoice Does not Exists');
        }
        if (CaseList::find($request->no_case)->hasInvoice()) {
            if (CaseList::find($request->no_case)->invoice->whereIn('type_invoice', [2, 3])->count() != 0) {
                return back()->with('error', 'invoiced is already exists');
            }
        }
        // dd(CaseList::find($request->no_case)->invoice->where('type_invoice',1)->count());
        try {
            DB::beginTransaction();
            $fee_based = str_replace(',', '', $request->fee_based);
            $fee_based = intval($fee_based);
            $caselist = CaseList::find($request->no_case);
            if ($caselist->currency == 'IDR') {
                $caselist->update([
                    'fee_idr' => $fee_based,
                    'wip_idr' => $fee_based,
                ]);
            }
            if ($caselist->currency == 'USD') {
                $caselist->update([
                    'fee_usd' => $fee_based,
                    'wip_usd' => $fee_based,
                ]);
            }
            $total = str_replace(',', '', $request->total);
            $total = intval($total);
            foreach (CaseList::find($request->no_case)->member as $key => $data) {
                Invoice::create([
                    'case_list_id' => $request->no_case,
                    'member_id' => $data->member_insurance,
                    'no_invoice' => $request->no_invoice[$key],
                    'date_invoice' => Carbon::createFromFormat('d/m/Y', $request->date_invoice)->format('Y-m-d'),
                    'due_date' => Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->date_invoice)->format('Y-m-d'))->addDays(30)->format('Y-m-d'),
                    'status_paid' => 0,
                    'bank_id' => 1,
                    'is_active' => 1,
                    'type_invoice' => $request->type_invoice,
                    'grand_total' => $total * $data->share / 100
                ]);
            }
            $expenses = Expense::where('case_list_id', $caselist->id)->where('is_active', 0)->get();

            foreach ($expenses as $expense) {
                $expense->update(['is_active' => 2]);
            }
            // dd($request->discount);
            if ($request->type_invoice == 2) {
                if ($request->type) {
                    if ($request->type == 1) {
                        $caselist->update([
                            'is_ready' => 3,
                            'discount' => str_replace(',', '', $request->discount),
                            'discount_percent' => 0
                        ]);
                    } else {
                        $caselist->update([
                            'is_ready' => 3,
                            'discount' => 0,
                            'discount_percent' => str_replace(',', '', $request->discount)
                        ]);
                    }
                } else {
                    $caselist->update([
                        'is_ready' => 3,
                    ]);
                }
            } else {
                if ($request->type) {
                    if ($request->type == 1) {
                        $caselist->update([
                            'is_ready' => 4,
                            'discount' => $request->discount
                        ]);
                    } else {
                        $caselist->update([
                            'is_ready' => 4,
                            'discount_percent' => $request->discount
                        ]);
                    }
                } else {
                    $caselist->update([
                        'is_ready' => 4,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Success create Invoice');
        } catch (Exception $err) {
            DB::rollBack();
            return back()->with('error', $err->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        //
    }

    public function edit(Invoice $invoice)
    {
        //
    }

    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    public function destroy(Invoice $invoice)
    {
        $caselist = CaseList::find($invoice->case_list_id);

        if ($caselist->ir_status == 1) {
            if ($invoice->type_invoice == 1) {
                $expense = Expense::where('case_list_id', $invoice->case_list_id)->get();

                foreach ($expense as $exp) {
                    $exp->update(['is_active' => 0]);
                }

                Invoice::where('case_list_id', $invoice->case_list_id)->where('type_invoice', 1)->delete();

                Invoice::onlyTrashed()->forceDelete();
                $caselist->update(['is_ready' => 1]);
            }
            // } else {
            //     $expense = Expense::where('case_list_id', $invoice->case_list_id)->get();

            //     foreach ($expense as $exp) {
            //         $exp->update(['is_active' => 0]);
            //     }

            //     Invoice::where('case_list_id', $invoice->case_list_id)->where('type_invoice', '!=',  1)->delete();

            //     Invoice::onlyTrashed()->forceDelete();
            //     $caselist->update(['is_ready' => 2]);
            // }
        } else {
            $expense = Expense::where('case_list_id', $invoice->case_list_id)->get();

            foreach ($expense as $exp) {
                $exp->update(['is_active' => 0]);
            }
            Invoice::where('case_list_id', $invoice->case_list_id)->delete();

            Invoice::onlyTrashed()->forceDelete();
            $caselist->update(['is_ready' => 2]);
        }



        return back()->with('success', 'Delete Successfull');
    }
    public function laporan(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'status' => 'required'
        ]);
        if ($request->status == 'all') {

            $rupiah = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'IDR');
            })->whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->sum('grand_total');

            $usd = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'USD');
            })->whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->sum('grand_total');

            $invoice = Invoice::whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->get();

            return view('invoice.laporan', [
                'from' => Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'),
                'to' => Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d'),
                'invoice' => $invoice,
                'usd' => $usd,
                'rupiah' => $rupiah
            ]);
        } else {
            $rupiah = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'IDR');
            })->whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->where('status_paid', $request->status)->sum('grand_total');

            $usd = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'USD');
            })->whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->where('status_paid', $request->status)->sum('grand_total');

            $invoice = Invoice::whereBetween('date_invoice', [Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d')])->where('status_paid', $request->status)->get();

            return view('invoice.laporan', [
                'from' => Carbon::createFromFormat('d/m/Y', $request->from)->format('Y-m-d'),
                'to' => Carbon::createFromFormat('d/m/Y', $request->to)->format('Y-m-d'),
                'invoice' => $invoice,
                'usd' => $usd,
                'rupiah' => $rupiah
            ]);
        }
    }
    public function excel(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        // ob_end_clean();
        // ob_start();
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');
        return Excel::download(new InvoiceExport($request->except(['_token'])), 'Invoice Excel ' . $timestamp . ' Report.xlsx');
    }

    public function final($id)
    {
        $invoices = Invoice::where('case_list_id', $id)->where('type_invoice', 2)->get();
        $caselist = CaseList::find($id);
        foreach ($invoices as $inv) {
            $inv->update(['type_invoice' => 3]);
        }

        $caselist->update(['is_ready' => 4]);

        return back()->with('success', 'Final invoice successfully created');
    }

    public function pdf($id)
    {
        $invoice = Invoice::findOrFail($id);
        $fee_based = new AjaxController();
        $fee = $fee_based->caselist($invoice->caselist->id)->original['sum']['fee'];

        $caselist = CaseList::where('id', $invoice->case_list_id)->first();
        if ($caselist->fee_idr == NULL) {
            $fee_adj = $caselist->fee_usd;
        } else {
            $fee_adj = $caselist->fee_idr;
        }
        // ob_end_clean();
        // ob_start();
        // test
        $share = $invoice->caselist->member->where('member_insurance', $invoice->member_id)->first()->share;
        // $interim = 0;
        // $case = CaseList::find($invoice->case_list_id);
        // if ($case->ir_status == 1) {
        //     $interim = intval(Invoice::where('case_list_id', $invoice->case_list_id)->where('type_invoice', 1)->where('is_active', 1)->sum('grand_total'));
        // }

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('invoice.pdf', [
            'invoice' => $invoice,
            'inv' => Invoice::findOrFail($id),
            'share' => $share,
            'fee' => $fee,
            'fee_adj' => $fee_adj,
            // 'interim' => $interim,
            'caselist' => $fee_based->caselist($invoice->caselist->id)->original['caselist'],
            'bank' => Bank::where('id', $invoice->bank_id)->get()->unique('bank_name'),
            'type' => Bank::get(),
        ]);
        return $pdf->stream();
    }
}
