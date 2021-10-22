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
                        <tbody>
                            @foreach($member as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><a href="{{ route('case-list.show', $data->caselist->id) }}">{{ $data->caselist->file_no ?? 'Kosong' }}</a></td>
                                <td class="text-right">{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->claim_amount) : ''}}</td>
                                <td class="text-right">{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->claim_amount) : '' }}</td>
                                <th class="text-center">{{ $data->is_leader ? 'Leader' : 'Member' }}</th>
                                <td class="text-center">{{ $data->share }}%</td>
                                <td>{{ $data->caselist->incident->type_incident ?? 'Kosong' }}</td>
                                <th>{{ $data->caselist->instruction_date }}</th>
                            </tr>
                            @endforeach
                        </tbody>
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
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "paging": false,
            "ordering": false
        })
    </script>
</body>

</html>