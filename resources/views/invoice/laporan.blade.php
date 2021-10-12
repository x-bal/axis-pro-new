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
</head>

<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <div>
                <h1>Laporan Invoice</h1>
            </div>
        </div>
        <br>
        <form action="{{ route('invoice.excel') }}" method="post">
            @csrf
            <div class="card">
                <div class="btn-group">
                    <a href="{{ route('invoice.index') }}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-success">Excel</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from">from</label>
                                <input type="date" id="from" name="from" class="form-control" readonly value="{{ $from }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to">to</label>
                                <input type="date" id="to" name="to" value="{{ $to }}" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Nomor Case</th>
                            <th rowspan="2">No Invoice</th>
                            <th rowspan="2">Member Insurance</th>
                            <th rowspan="2">Due Date</th>
                            <th rowspan="2">Date Invoice</th>
                            <th rowspan="2">Status Paid</th>
                            <th colspan="2" class="text-center">Grand Total</th>
                        </tr>
                        <tr>
                            <th>Rupiah</th>
                            <th>Usd</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->caselist->file_no }}</td>
                            <td>{{ $data->no_invoice }}</td>
                            <td>{{ $data->member->name }}</td>
                            <td>{{ $data->due_date }}</td>
                            <td>{{ $data->date_invoice }}</td>
                            <td class="text-center">{{ $data->status_paid }}</td>
                            <td class="text-center">@if($data->caselist->currency == 'RP')<strong>Rp.</strong> {{ number_format($data->grand_total) }}@endif</td>
                            <td class="text-center">@if($data->caselist->currency == 'USD')<i class="fas fa-dollar-sign"></i> {{ number_format($data->grand_total) }}@endif</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="7">Total</th>
                            <td class="text-center"><strong>Rp.</strong> {{ number_format($rupiah) }}</td>
                            <td class="text-center"><i class="fas fa-dollar-sign"></i> {{ number_format($usd) }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>
    <script>
        $('#table').DataTable({
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                className: 'dtr-control',
                responsivePriority: 1,
                targets: 0
            }, {
                responsivePriority: 2,
                targets: 1
            }],
            orderable: false,
            searchable: false,
            searching: false,
            paginate: false
        })
    </script>
</body>

</html>