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
        <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Insurance</th>
                                <th>File No</th>
                                <th>Incident</th>
                                <th>Policy</th>
                                <th>Category</th>
                                <th>Instruction Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $data->name }}</th>
                                <td>
                                    <ul class="unstyled-list">
                                        @foreach($data->caselist->whereBetween('instruction_date',[$from,$to]) as $row)
                                        <li><a href="{{ route('case-list.show',$row->id) }}">{{ $row->file_no }}</a></li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul class="unstyled-list">
                                        @foreach($data->caselist->whereBetween('instruction_date',[$from,$to]) as $row)
                                        <li>{{ $row->incident->type_incident }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul class="unstyled-list">
                                        @foreach($data->caselist->whereBetween('instruction_date',[$from,$to]) as $row)
                                        <li>{{ $row->policy->type_policy }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul class="unstyled-list">
                                        @foreach($data->caselist->whereBetween('instruction_date',[$from,$to]) as $row)
                                        <li>@if($row->category == 1) Marine @else Non Marine @endif</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <th>
                                    <ul class="unstyled-list">
                                        @foreach($data->caselist->whereBetween('instruction_date',[$from,$to]) as $row)
                                        <li>{{ \Carbon\Carbon::parse($row->instruction_date)->format('d/m/Y')  }}</li>
                                        @endforeach
                                    </ul>
                                </th>
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
            ]
        })
    </script>
</body>

</html>