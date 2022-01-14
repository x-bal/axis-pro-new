<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Case Lists Tanggal {{ Carbon\Carbon::parse($from)->format('d/m/Y') }} s.d {{ Carbon\Carbon::parse($from)->format('d/m/Y') }} - {{ $status == 5 ? 'Closed File' : $status }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <div>
                <h1> Laporan Case List</h1>
                <div class="d-flex justify-content-between">
                    <strong>{{ $from }}</strong>
                    <strong>{{ $to }}</strong>
                </div>
            </div>

        </div>
        <hr>
        {{--<br>
        <form action="{{ route('caselist.excel') }}" method="post">
        @csrf
        <div class="card">
            <div class="btn-group">
                <a href="{{ route('case-list.index') }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-success">Excel</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="from">from</label>
                            <input type="date" id="from" name="from" class="form-control" readonly value="{{ $from }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="to">to</label>
                            <input type="date" id="to" name="to" value="{{ $to }}" readonly class="form-control">
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin'))

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjuster">adjuster</label>
                            <input type="text" id="adjuster" name="adjuster" value="{{ $adjuster }}" readonly class="form-control">
                        </div>
                    </div>
                    @else
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">status</label>
                            <input type="text" id="status" name="status" value="{{ $status }}" readonly class="form-control">
                        </div>
                    </div>

                    @endif
                </div>
            </div>

        </div>
        </form>
        <br> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" style="font-size: 15px;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>No.</th>
                                <th>File No</th>
                                <th>Adjuster</th>
                                <th colspan="3">Insurances</th>
                                <th>Broker</th>
                                <th>Incident</th>
                                <th>Policy</th>
                                <th>Category</th>
                                <th>Insured</th>
                                <th>DOL</th>
                                <th>Risk Location / Project</th>
                                <th>Ledaer Policy No</th>
                                <th>Claim No</th>
                                <th>Period Begin Date</th>
                                <th>Period End Date</th>
                                <th>Instruction Date</th>
                                <th>Survey Date</th>
                                <th>Now Update</th>

                                @if($status != '5')
                                <th>IA Date</th>
                                <th>IA Curr</th>
                                <th>IA Amount</th>
                                <th>PR Date</th>
                                <th>PR Curr</th>
                                <th>PR Amount</th>
                                <th>IR St Date</th>
                                <th>IR St Curr</th>
                                <th>IR St Amount</th>
                                <th>IR Nd Date</th>
                                <th>IR Nd Curr</th>
                                <th>IR Nd Amount</th>
                                <th>PA Date</th>
                                <th>PA Curr</th>
                                <th>PA Amount</th>
                                <th>FR Date</th>
                                <th>FR Curr</th>
                                <th>FR Amount</th>
                                @endif

                                <th>Remark</th>
                                <th>File Status</th>
                                <th>Date Instruction Closed</th>
                                <th>PIC Insurers</th>

                                @if($status == '5' || $status == 'all')
                                <th colspan="2">Claim Amount</th>
                                <th colspan="2">Gross Adjustment</th>
                                <th colspan="2">Fee</th>
                                <th colspan="2">Expense</th>
                                <th colspan="2">PPN 10%</th>
                                <th colspan="2">Total Invoice</th>
                                @endif

                                @if($status == 'outstanding')
                                <th colspan="2">Claim Amount</th>
                                @endif
                                <th>Status Paid</th>
                            </tr>

                            <tr>
                                <th colspan="3"></th>
                                <th>Name</th>
                                <th>Share</th>
                                <th>Leader / Member</th>
                                @if($status == 'all' )
                                <th colspan="36"></th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                @endif

                                @if($status == 'outstanding')
                                <th colspan="36"></th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th></th>
                                @endif

                                @if($status == 5)
                                <th colspan="18"></th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th>IDR</th>
                                <th>USD</th>
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        @php
                        $claim_amount_idr = 0;
                        $claim_amount_usd = 0;
                        $claim_estimate_idr = 0;
                        $claim_estimate_usd = 0;
                        $expense_idr = 0;
                        $expense_usd = 0;
                        $fee_idr = 0;
                        $fee_usd = 0;
                        $totalPpn= 0;
                        $ppn_usd = 0;
                        $invoice_idr = 0;
                        $invoice_usd = 0;
                        @endphp

                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach($case as $caselist)
                            @php
                            $caselist->claim_amount_curr == 'IDR' ? $expense_idr += App\Models\Expense::where('case_list_id', $caselist->id)->sum('total') : $expense_usd += App\Models\Expense::where('case_list_id', $caselist->id)->sum('total');
                            $caselist->claim_amount_curr == 'IDR' ? $invoice_idr = $expense_idr + $case->sum('fee_idr') : $invoice_usd = $expense_usd + $case->sum('fee_usd');
                            @endphp
                            @foreach($caselist->member as $member)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $caselist->file_no }}</td>
                                <td>{{ $caselist->adjuster->kode_adjuster }}</td>
                                <td>{{ $member->insurance->name }}</td>
                                <td>{{ $member->share }}%</td>
                                <td>{{ $member->is_leader == 1 ? 'Leader' : 'Member' }}</td>
                                <td>{{ $caselist->broker->nama_broker }}</td>
                                <td>{{ $caselist->incident->type_incident }}</td>
                                <td>{{ $caselist->policy->type_policy }}</td>
                                <td>{{ $caselist->category == 1 ? 'Marine' : 'Non Marine' }}</td>
                                <td>{{ $caselist->insured }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->dol)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->risk_location }}</td>
                                <td>{{ $caselist->no_leader_policy }}</td>
                                <td>{{ $caselist->leader_claim_no }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->begin)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->end)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->instruction_date)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->survey)->format('d/m/Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->now_update)->format('d/m/Y') }}</td>
                                <!-- All & Outstanding -->
                                @if($status != '5')
                                <td>{{ Carbon\Carbon::parse($caselist->ia_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->ia_curr }}</td>
                                <td>{{ number_format($caselist->ia_amount, 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->pr_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->pr_curr }}</td>
                                <td>{{ number_format($caselist->pr_amount, 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->ir_st_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->ir_st_curr }}</td>
                                <td>{{ number_format($caselist->ir_st_amount, 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->ir_nd_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->ir_nd_curr }}</td>
                                <td>{{ number_format($caselist->ir_nd_amount, 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->pa_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->pa_curr }}</td>
                                <td>{{ number_format($caselist->pa_amount, 2) }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->fr_date)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->fr_curr }}</td>
                                <td>{{ number_format($caselist->fr_amount, 2) }}</td>
                                @endif
                                <!-- All & Outstanding -->

                                <td>{{ $caselist->remark }}</td>
                                <td>{{ $caselist->status->nama_status }}</td>
                                <td>{{ Carbon\Carbon::parse($caselist->date_insctruction)->format('d/m/Y') }}</td>
                                <td>{{ $caselist->pic_insurer }}</td>

                                @php
                                $caselist->currency == 'IDR' ? $claim_estimate_idr += $caselist->claim_estimate : $claim_estimate_usd += $caselist->claim_estimate;
                                $caselist->claim_amount_curr == 'IDR' ? $claim_amount_idr += $caselist->claim_amount : $claim_amount_usd += $caselist->claim_amount;
                                @endphp
                                <td>{{ $caselist->currency == 'IDR' ? number_format($caselist->claim_estimate, 2) : number_format(0,2) }}</td>
                                <td>{{ $caselist->currency == 'USD' ? number_format($caselist->claim_estimate, 2) : number_format(0,2) }}</td>
                                @if($status == 'all' || $status == '5')
                                <td>{{ $caselist->currency == 'IDR' ? number_format($caselist->claim_amount, 2) : number_format(0,2) }}</td>
                                <td>{{ $caselist->currency == 'USD' ? number_format($caselist->claim_amount, 2) : number_format(0,2) }}</td>
                                <td>{{ $caselist->claim_amount_curr == 'IDR' ? number_format($caselist->fee_idr * $member->share /100 , 2) : number_format(0,2) }}</td>\
                                <td>{{ $caselist->claim_amount_curr == 'USD' ? number_format($caselist->fee_usd * $member->share /100, 2) : number_format(0,2) }}</td>
                                <td>{{ $caselist->claim_amount_curr == 'IDR' ? number_format($caselist->expense()->sum('total') * $member->share /100 , 2) : number_format(0,2) }}</td>
                                <td>{{ $caselist->claim_amount_curr == 'USD' ? number_format($caselist->expense()->sum('total') * $member->share /100, 2) : number_format(0,2) }}</td>
                                <td>
                                    @php
                                    $ppn = ($caselist->fee_idr + $caselist->expense()->sum('total')) * 10 / 100
                                    @endphp
                                    {{ $caselist->claim_amount_curr == 'IDR' ? number_format($ppn * $member->share /100 , 2) : number_format(0,2) }}
                                </td>
                                <td>
                                    @php
                                    $ppn = ($caselist->fee_usd + $caselist->expense()->sum('total')) * 10 / 100
                                    @endphp
                                    {{ $caselist->claim_amount_curr == 'USD' ? number_format($ppn * $member->share /100, 2) : number_format(0,2) }}
                                </td>
                                <td>
                                    @php
                                    $ppnidr = ($caselist->fee_idr + $caselist->expense()->sum('total')) * 10 / 100;
                                    $total = $caselist->fee_idr + $caselist->expense()->sum('total') + $ppnidr
                                    @endphp
                                    {{ $caselist->claim_amount_curr == 'IDR' ? number_format($total * $member->share /100 , 2) : number_format(0,2) }}
                                </td>
                                <td>
                                    @php
                                    $ppnusd = ($caselist->fee_usd + $caselist->expense()->sum('total')) * 10 / 100;
                                    $total = $total = $caselist->fee_usd + $caselist->expense()->sum('total') + $ppnusd
                                    @endphp
                                    {{ $caselist->claim_amount_curr == 'USD' ? number_format($total * $member->share /100, 2) : number_format(0,2) }}
                                </td>
                                @endif
                                <td>
                                    {{ App\Models\Invoice::where('member_id', $member->member_insurance)->first() ? App\Models\Invoice::where('member_id', $member->member_insurance)->first()->status_paid == 1 ? 'Paid' : 'Unpaid' : 'Unpaid' }}
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Total : </th>
                                @if($status == 'all')
                                <th colspan="21"></th>
                                <th>{{ number_format($case->sum('ia_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('pr_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('ir_st_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('ir_nd_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('pa_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('fr_amount'), 2) }}</th>
                                <th colspan="4"></th>
                                @endif
                                @if($status == '5')
                                <th colspan="23"></th>
                                @endif

                                @if($status == 'outstanding')
                                <th colspan="21"></th>
                                <th>{{ number_format($case->sum('ia_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('pr_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('ir_st_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('ir_nd_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('pa_amount'), 2) }}</th>
                                <th colspan="2"></th>
                                <th>{{ number_format($case->sum('fr_amount'), 2) }}</th>
                                <th colspan="4"></th>
                                @endif

                                <th>
                                    {{ number_format($claim_estimate_idr, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($claim_estimate_usd) ?? number_format(0,2) }}
                                </th>
                                @if($status == 'all' || $status == '5')
                                <th>
                                    {{ number_format($claim_amount_idr, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($claim_amount_usd) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($case->sum('fee_idr'), 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($case->sum('fee_usd'), 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($expense_idr, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($expense_usd, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format(($expense_idr + $case->sum('fee_idr')) * 10 / 100, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format(($expense_usd + $case->sum('fee_usd')) * 10 / 100, 2) ?? number_format(0,2) }}
                                </th>
                                <th>
                                    {{ number_format($invoice_idr + ($expense_idr + $case->sum('fee_idr')) * 10 / 100, 2) }}
                                </th>
                                <th>
                                    {{ number_format($invoice_usd + ($expense_usd + $case->sum('fee_usd')) * 10 / 100, 2) }}
                                </th>
                                @endif
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        modifier: {
                            page: 'all'
                        },
                        columns: ':visible',
                    }
                },
                'copy', 'csv', 'pdf', 'print'
            ],
            columnDefs: [{
                visible: true
            }],
            "paging": false,
            "ordering": false,
            "searching": false
        })
    </script>
</body>

</html>