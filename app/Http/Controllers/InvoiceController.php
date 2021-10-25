<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\Bank;
use App\Models\CaseList;
use App\Models\Client;
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
            return back()->with('error', 'invoiced is already exists');
        }
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
                    'date_invoice' => $request->date_invoice,
                    'due_date' => Carbon::parse($request->date_invoice)->addDays(30)->format('Y-m-d'),
                    'status_paid' => 0,
                    'is_active' => 1,
                    'type_invoice' => $request->type_invoice,
                    'grand_total' => $total * $data->share / 100
                ]);
            }
            if ($request->type_invoice == 2) {
                $caselist->update(['is_ready' => 2]);
            } else {
                $caselist->update(['is_ready' => 4]);
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
        Invoice::where('case_list_id', $invoice->case_list_id)->delete();
        Invoice::onlyTrashed()->forceDelete();
        CaseList::find($invoice->case_list_id)->update(['is_ready' => 3]);

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
            })->whereBetween('date_invoice', [$request->from, $request->to])->sum('grand_total');

            $usd = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'USD');
            })->whereBetween('date_invoice', [$request->from, $request->to])->sum('grand_total');

            $invoice = Invoice::whereBetween('date_invoice', [$request->from, $request->to])->get();

            return view('invoice.laporan', [
                'from' => $request->from,
                'to' => $request->to,
                'invoice' => $invoice,
                'usd' => $usd,
                'rupiah' => $rupiah
            ]);
        } else {
            $rupiah = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'IDR');
            })->whereBetween('date_invoice', [$request->from, $request->to])->where('status_paid', $request->status)->sum('grand_total');

            $usd = Invoice::whereHas('caselist', function ($qr) {
                return $qr->where('currency', 'USD');
            })->whereBetween('date_invoice', [$request->from, $request->to])->where('status_paid', $request->status)->sum('grand_total');

            $invoice = Invoice::whereBetween('date_invoice', [$request->from, $request->to])->where('status_paid', $request->status)->get();

            return view('invoice.laporan', [
                'from' => $request->from,
                'to' => $request->to,
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
    public function pdf($id)
    {
        $invoice = Invoice::findOrFail($id);
        $fee_based = new AjaxController();
        $fee = $fee_based->caselist($invoice->caselist->id)->original['sum']['fee'];
        // ob_end_clean();
        // ob_start();
        // test
        $share = $invoice->caselist->member->where('member_insurance', $invoice->member_id)->first()->share;
        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('invoice.pdf', [
            'invoice' => $invoice,
            'inv' => Invoice::findOrFail($id),
            'share' => $share,
            'fee' => $fee,
            'caselist' => $fee_based->caselist($invoice->caselist->id)->original['caselist'],
            'bank' => Bank::where('id', $invoice->bank_id)->get()->unique('bank_name'),
            'type' => Bank::get(),
        ]);
        return $pdf->stream();
    }
}
