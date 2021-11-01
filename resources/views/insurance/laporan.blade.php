<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <h1>Laporan Insurance</h1>
                <div class="d-flex justify-content-between">
                    <strong>{{ $from }}</strong>
                    <strong>{{ $to }}</strong>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">File No</th>
                                <th rowspan="2">Initial Adjuster</th>
                                <th colspan="3">Insurances</th>
                                <th rowspan="2">Leader</th>
                                <th rowspan="2">Insured</th>
                                <th rowspan="2">DOL</th>
                                <th rowspan="2">Risk Location/ Project</th>
                                <th rowspan="2">Broker</th>
                                <th rowspan="2">Type Of Bussiness</th>
                                <th rowspan="2">Cause Of Loss</th>
                                <th colspan="3">Leader Policy</th>
                                <th rowspan="2">Leader Claim No</th>
                                <th rowspan="2">Instruction Date</th>
                                <th rowspan="2">Survey Date</th>
                                <th colspan="2">Claim Amount (Gross)</th>
                                <th rowspan="2">Outstanding/Close File</th>
                                <th rowspan="2">Date</th>
                                <th rowspan="2">Invoice</th>
                                <th colspan="2">Adjuster Fee</th>
                                <th colspan="2">Expenses</th>
                                <th colspan="2">PPN 10%</th>
                                <th colspan="2">Invoice</th>
                                <th rowspan="2">Aging Day</th>
                                <th rowspan="2">Paid/Unpaid</th>
                                <th rowspan="2">Remarks</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Share</th>
                                <th>Leader/Member</th>
                                <th>No</th>
                                <th>Begin</th>
                                <th>End</th>
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
                            </tr>
                        </thead>
                        @php
                        $claim_amount_idr = 0;
                        $claim_amount_usd = 0;
                        $fee_idr = 0;
                        $fee_usd = 0;
                        $expense_idr = 0;
                        $expense_usd = 0;
                        $ppn_idr = 0;
                        $ppn_usd = 0;
                        $invoice_idr = 0;
                        $invoice_usd = 0;
                        @endphp
                        <tbody>
                            @foreach($member as $data)
                            @if($data->caselist->currency == 'IDR')
                                @php 
                                $claim_amount_idr += $data->caselist->claim_amount;
                                $fee_idr += $data->caselist->fee_idr;
                                $expense_idr += $data->caselist->expense->sum('total');
                                $ppn_idr += ($data->caselist->fee_idr + $data->caselist->expense->sum('total')) * 10 / 100;
                                $invoice_idr += ($data->caselist->claim_amount + $data->caselist->fee_idr) + (($data->caselist->fee_idr + $data->caselist->expense->sum('total')) * 10 / 100);
                                @endphp 
                            @endif
                            @if($data->caselist->currency == 'USD')
                                @php
                                $claim_amount_usd += $data->caselist->claim_amount;
                                $fee_usd += $data->caselist->fee_usd;
                                $expense_usd += $data->caselist->expense->sum('total');
                                $ppn_usd += ($data->caselist->fee_usd + $data->caselist->expense->sum('total')) * 10 / 100;
                                $invoice_usd += ($data->caselist->claim_amount + $data->caselist->fee_usd) + (($data->caselist->fee_usd + $data->caselist->expense->sum('total')) * 10 / 100);
                                @endphp 
                            @endif
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('case-list.show',$data->caselist->id) }}">{{ $data->caselist->file_no }}</a></td>
                                <td>{{ $data->caselist->adjuster->kode_adjuster }}</td>
                                <td>{{ $data->client->brand }} - {{ $data->client->name }}</td>
                                <td>{{ $data->share }}</td>
                                <td>{{ $data->is_leader ? 'Leader' : 'Member' }}</td>
                                <td>{{ $data->caselist->leader_id->brand }} - {{ $data->caselist->leader_id->name }}</td>
                                <td>{{ $data->caselist->insured }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->caselist->dol)->format('d-M-Y') }}</td>
                                <td>{{ $data->caselist->risk_location }}</td>
                                <td>{{ $data->caselist->broker->nama_broker }}</td>
                                <td>{{ $data->caselist->policy->type_policy }}</td>
                                <td>{{ $data->caselist->incident->type_incident }}</td>
                                <td>{{ $data->caselist->no_leader_policy }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->caselist->begin)->format('d-M-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->caselist->end)->format('d-M-Y') }}</td>
                                <td>{{ $data->caselist->leader_claim_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->caselist->instruction_date)->format('d-M-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->caselist->survey_date)->format('d-M-Y') }}</td>
                                <!-- claim amount -->
                                <td>{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->claim_amount) ?? '0' : '0' }}</td>
                                <td>{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->claim_amount) ?? '0' : '0' }}</td>
                                <!-- claim amount -->
                                <td>{{ $data->caselist->status->nama_status }}</td>
                                <td>{{ $data->caselist->invoice->where('member_id',$data->client->id)->first()->date_invoice ?? 'Kosong'  }}</td>
                                <td>{{ $data->caselist->invoice->where('member_id', $data->client->id)->first()->no_invoice ?? 'Kosong'  }}</td>
                                <!-- fee -->
                                <td>{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->fee_idr) : '0' }}</td>
                                <td>{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->fee_usd) : '0' }}</td>
                                <!-- fee -->
                                <!-- expense -->
                                <td>{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->expense->sum('total')) : '0' }}</td>
                                <td>{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->expense->sum('total')) : '0' }}</td>
                                <!-- expense --> 
                                <!-- ppn -->
                                <td>{{ $data->caselist->currency == 'IDR' ? number_format(($data->caselist->fee_idr + $data->caselist->expense->sum('total')) * 10 / 100) : '0' }}</td>
                                <td>{{ $data->caselist->currency == 'USD' ? number_format(($data->caselist->fee_usd + $data->caselist->expense->sum('total')) * 10 / 100) : '0' }}</td>
                                <!-- ppn -->
                                <!-- invoice -->
                                <td>{{ $data->caselist->currency == 'IDR' ? number_format(($data->caselist->claim_amount + $data->caselist->fee_idr) + (($data->caselist->fee_idr + $data->caselist->expense->sum('total')) * 10 / 100)) : '0' }} </td>
                                <td>{{ $data->caselist->currency == 'USD' ? number_format(($data->caselist->claim_amount + $data->caselist->fee_usd) + (($data->caselist->fee_usd + $data->caselist->expense->sum('total')) * 10 / 100)) : '0' }}</td>
                                <!-- invoice -->
                                <td>{{ \Carbon\Carbon::parse($data->caselist->instruction_date)->diff($data->caselist->file_status_id == 5 ? $data->caselist->now_update : Carbon\Carbon::now())->d  }}</td>
                                <td>{{ $data->caselist->invoice->where('member_id',$data->client->id)->first()->status_paid ?? 'Kosong' }}</td>
                                <td>{{ $data->caselist->remark  }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th colspan="19">Total</th>
                            <th>{{ number_format($claim_amount_idr) }}</th>
                            <th>{{ number_format($claim_amount_usd) }}</th>
                            <th colspan="3"></th>
                            <th>{{ number_format($fee_idr) }}</th>
                            <th>{{ number_format($fee_usd) }}</th>
                            <th>{{ number_format($expense_idr) }}</th>
                            <th>{{ number_format($expense_usd) }}</th>
                            <th>{{ number_format($ppn_idr) }}</th>
                            <th>{{ number_format($ppn_usd) }}</th>
                            <th>{{ number_format($invoice_idr) }}</th>
                            <th>{{ number_format($invoice_usd) }}</th>
                        </tfoot>
                    </table>
                    {{--<table class="table table-bordered" id="table" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">File No</th>
                                <th colspan="2">Invoice</th>
                                <th rowspan="2">Leader / Member</th>
                                <th rowspan="2">Member Share</th>
                                <th rowspan="2">Cause Of Lost</th>
                                <th rowspan="2">Insturction Date</th>
                            </tr>
                            <tr>
                                <th>Rp</th>
                                <th>Usd</th>
                            </tr>
                        </thead>
                        @php
                            $total_idr = 0;
                            $total_usd = 0;
                        @endphp
                        <tbody>
                            @foreach($member as $data)
                            <tr>
                                @if($data->caselist->currency == 'IDR')
                                    @php $total_idr += $data->caselist->claim_amount @endphp
                                @endif
                                @if($data->caselist->currency == 'USD')
                                    @php $total_usd += $data->caselist->claim_amount @endphp
                                @endif
                                <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ route('case-list.show', $data->caselist->id) }}">{{ $data->caselist->file_no ?? 'Kosong' }}</a></td>
                    <td>{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->claim_amount) : ''}}</td>
                    <td>{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->claim_amount) : '' }}</td>
                    <th>{{ $data->is_leader ? 'Leader' : 'Member' }}</th>
                    <td>{{ $data->share }}%</td>
                    <td>{{ $data->caselist->incident->type_incident ?? 'Kosong' }}</td>
                    <th>{{ $data->caselist->instruction_date }}</th>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td>{{ number_format($total_idr) }}</td>
                            <td>{{ number_format($total_usd) }}</td>
                            <td colspan="4"></td>
                        </tr>
                    </tfoot>
                    </table>--}}
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
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "paging": false,
            "ordering": false
        })
    </script>
</body>

</html>