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
                                <th>Insurance</th>
                                <th>Adjuster</th>
                                <th>Broker</th>
                                <th>Incident</th>
                                <th>Policy</th>
                                <th>Category</th>
                                <th>Insured</th>
                                @if($status == 'all')
                                <th colspan="2">Claim Amount</th>
                                <th colspan="2">Fee</th>
                                <th colspan="2">Expense</th>
                                <th colspan="2">PPN 10%</th>
                                <th colspan="2">Total Invoice</th>
                                @endif
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
                                <!-- <th>IR Curr</th> -->
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
                                @if($status == 5)
                                <th colspan="2">Claim Amount</th>
                                <th colspan="2">Fee</th>
                                <th colspan="2">Expense</th>
                                <th colspan="2">PPN 10%</th>
                                <th colspan="2">Total Invoice</th>
                                @endif
                            </tr>
                            @if($status == '5')
                            <tr>
                                <td colspan="14"></td>
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
                            @endif
                            @if($status == 'all')
                            <tr>
                                <td colspan="9"></td>
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
                                <td colspan="24"></td>
                            </tr>
                            @endif
                        </thead>
                        @php
                        $expense_idr = 0;
                        $expense_usd = 0;
                        $ppn_idr = 0;
                        $ppn_usd = 0;
                        $invoice_idr = 0;
                        $invoice_usd = 0;
                        @endphp
                        <tbody>
                            @foreach($case as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->file_no }}</td>
                                <td>{{ $data->insurance->name }}</td>
                                <td><strong>{{ $data->adjuster->nama_lengkap }}</strong></td>
                                <td>{{ $data->broker->nama_broker }}</td>
                                <td>{{ $data->incident->type_incident }}</td>
                                <td>{{ $data->policy->type_policy }}</td>
                                <td>@if($data->category == 1) Marine @else Non Marine @endif</td>
                                <td>{{ $data->insured }}</td>
                                @if($status == 'all')
                                <!-- claim amount -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format($data->claim_amount) }} @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->claim_amount)  }} @else 0 @endif</td>
                                <!-- claim amount -->
                                <!-- fee based  -->
                                <td>@if($data->claim_amount_curr == 'IDR') {{ number_format($data->fee_idr) }} @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->fee_usd) }} @else 0 @endif</td>
                                <!-- fee based  -->
                                <!-- expense -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format($data->expense->sum('total')) }} @php $expense_idr += $data->expense->sum('total') @endphp @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->expense->sum('total')) }} @php $expense_usd += $data->expense->sum('total') @endphp @else 0 @endif</td>
                                <!-- expense -->
                                <!-- ppn -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format(($data->fee_idr + $data->expense->sum('total')) * 10 / 100) }} @php $ppn_idr += ($data->fee_idr + $data->expense->sum('total')) * 10 / 100 @endphp @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format(($data->fee_usd + $data->expense->sum('total')) * 10 / 100) }} @php $ppn_usd += ($data->fee_usd + $data->expense->sum('total')) * 10 / 100 @endphp @else 0 @endif</td>
                                <!-- ppn -->
                                <!-- invoice  -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format(($data->claim_amount + $data->fee_idr) + (($data->fee_idr + $data->expense->sum('total')) * 10 / 100)) }} @php $invoice_idr += ($data->claim_amount + $data->fee_idr) + (($data->fee_idr + $data->expense->sum('total')) * 10 / 100) @endphp @else 0 @endif </td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format(($data->claim_amount + $data->fee_usd) + (($data->fee_usd + $data->expense->sum('total')) * 10 / 100)) }} @php $invoice_usd += ($data->claim_amount + $data->fee_usd) + (($data->fee_usd + $data->expense->sum('total')) * 10 / 100) @endphp @else 0 @endif</td>
                                <!-- invoice -->
                                @endif
                                <td>{{ $data->instruction_date ? \Carbon\Carbon::parse($data->instruction_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->survey_date ? \Carbon\Carbon::parse($data->survey_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->now_update ? \Carbon\Carbon::parse($data->now_update)->format('d/m/Y') : '' }}</td>
                                @if($status != 5)
                                <td>{{ $data->ia_date ? \Carbon\Carbon::parse($data->ia_date)->format('d/m/Y') : ''}}</td>
                                <td>{{ $data->ia_curr }}</td>
                                <td> <strong>{{ number_format($data->ia_amount) }}</strong></td>
                                <td>{{ $data->pr_date ? \Carbon\Carbon::parse($data->pr_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->pr_curr }}</td>
                                <td><strong>{{ number_format($data->pr_amount) }}</strong></td>
                                <!-- <td>{{ $data->ir_status }}</td> -->
                                <td>{{ $data->ir_st_date ? \Carbon\Carbon::parse($data->ir_st_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->ir_st_curr }}</td>
                                <td><strong>{{ number_format($data->ir_st_amount) }}</strong></td>
                                <td>{{ $data->ir_nd_date ? \Carbon\Carbon::parse($data->ir_nd_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->ir_nd_curr }}</td>
                                <td><strong>{{ number_format($data->ir_nd_amount) }}</strong></td>
                                <td>{{ $data->pa_date ? \Carbon\Carbon::parse($data->pa_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->pa_curr }}</td>
                                <td><strong>{{ number_format($data->pa_amount) }}</strong></td>
                                <td>{{ $data->fr_date ? \Carbon\Carbon::parse($data->fr_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $data->fr_curr }}</td>
                                <td><strong>{{ number_format($data->fr_amount) }}</strong></td>
                                @endif
                                <td>{{ $data->remark }}</td>
                                <td>{{ $data->status->nama_status }}</td>
                                @if($status == 5)
                                <!-- claim amount -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format($data->claim_amount) }} @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->claim_amount)  }} @else 0 @endif</td>
                                <!-- claim amount -->
                                <!-- fee based  -->
                                <td>@if($data->claim_amount_curr == 'IDR') {{ number_format($data->fee_idr) }} @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->fee_usd) }} @else 0 @endif</td>
                                <!-- fee based  -->
                                <!-- expense -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format($data->expense->sum('total')) }} @php $expense_idr += $data->expense->sum('total') @endphp @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format($data->expense->sum('total')) }} @php $expense_usd += $data->expense->sum('total') @endphp @else 0 @endif</td>
                                <!-- expense -->
                                <!-- ppn -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format(($data->fee_idr + $data->expense->sum('total')) * 10 / 100) }} @php $ppn_idr += ($data->fee_idr + $data->expense->sum('total')) * 10 / 100 @endphp @else 0 @endif</td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format(($data->fee_usd + $data->expense->sum('total')) * 10 / 100) }} @php $ppn_usd += ($data->fee_usd + $data->expense->sum('total')) * 10 / 100 @endphp @else 0 @endif</td>
                                <!-- ppn -->
                                <!-- invoice  -->
                                <td>@if($data->claim_amount_curr == 'IDR'){{ number_format(($data->claim_amount + $data->fee_idr) + (($data->fee_idr + $data->expense->sum('total')) * 10 / 100)) }} @php $invoice_idr += ($data->claim_amount + $data->fee_idr) + (($data->fee_idr + $data->expense->sum('total')) * 10 / 100) @endphp @else 0 @endif </td>
                                <td>@if($data->claim_amount_curr == 'USD') {{ number_format(($data->claim_amount + $data->fee_usd) + (($data->fee_usd + $data->expense->sum('total')) * 10 / 100)) }} @php $invoice_usd += ($data->claim_amount + $data->fee_usd) + (($data->fee_usd + $data->expense->sum('total')) * 10 / 100) @endphp @else 0 @endif</td>
                                <!-- invoice -->
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if($status == 'all')
                            <tr>
                                <td>Total : </td>
                                <td colspan="8"></td>
                                <td>{{ number_format($claim_amount_idr) }}</td>
                                <td>{{ number_format($claim_amount_usd) }}</td>
                                <td>{{ number_format($fee_idr) }}</td>
                                <td>{{ number_format($fee_usd) }}</td>
                                <td>{{ number_format($expense_idr) }}</td>
                                <td>{{ number_format($expense_usd) }}</td>
                                <td>{{ number_format($ppn_idr) }}</td>
                                <td>{{ number_format($ppn_usd) }}</td>
                                <td>{{ number_format($invoice_idr) }}</td>
                                <td>{{ number_format($invoice_usd) }}</td>
                                <td colspan="24"></td>
                            </tr>
                            @endif
                            @if($status == 5)
                            <tr>
                                <td>Total : </td>
                                <td colspan="13"></td>
                                <td>{{ number_format($claim_amount_idr) }}</td>
                                <td>{{ number_format($claim_amount_usd) }}</td>
                                <td>{{ number_format($fee_idr) }}</td>
                                <td>{{ number_format($fee_usd) }}</td>
                                <td>{{ number_format($expense_idr) }}</td>
                                <td>{{ number_format($expense_usd) }}</td>
                                <td>{{ number_format($ppn_idr) }}</td>
                                <td>{{ number_format($ppn_usd) }}</td>
                                <td>{{ number_format($invoice_idr) }}</td>
                                <td>{{ number_format($invoice_usd) }}</td>
                            </tr>
                            @endif
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