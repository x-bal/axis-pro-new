@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Expense List') }}
                    </div>
                </div>
                <div class="table-responsive">
                    <form action="{{ route('expense.laporan') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" autocomplete="off" name="from" id="from" class="form-control @error('from') is-invalid @enderror">
                                    @error('from')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" autocomplete="off" name="to" id="to" class="form-control @error('to') is-invalid @enderror">
                                    @error('to')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsvie-lg">
                        <table class="table table-striped table-bordered" width="100%" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>File No</th>
                                    <th>Insured</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($caselists as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('case-list.show',$data->id) }}?page=nav-expense">{{ $data->file_no }}</a></td>
                                    <td>{{ $data->insured }}</td>
                                    <td>{{ $data->status->nama_status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('expense.update') }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" id="id_expense">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="">qty</label>
                        <input type="number" class="form-control" name="qty" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Log Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="logtable">
                    <thead>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Old</th>
                        <th>New</th>
                        <th>Datetime</th>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    function expenseedit(qr) {
        let id = $(qr).attr('data-id')
        $('#id_expense').val($(qr).attr('data-id'))
        $.ajax({
            url: `/api/admin/expense/show/${id}`,
            success: function(resource) {
                $('#name').val(resource.name)
                $('#qty').val(resource.qty)
                $('#nominal').val(resource.amount)
            },
            error: function(error) {
                alert(error.statusText)
            }
        })
    }

    function expenselog(qr) {
        let id = $(qr).attr('data-id')
        $('#logtable').DataTable({
            serverSide: true,
            processing: true,
            destroy: true,
            order: [
                [4, 'desc']
            ],
            ajax: `/api/admin/expense/log/${id}`,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'old',
                    name: 'old'
                },
                {
                    data: 'new',
                    name: 'new'
                },
                {
                    data: 'datetime',
                    name: 'datetime'
                },
            ]
        })

    }
    $('.table').DataTable()

    $("#from").datepicker({
        dateFormat: "dd/mm/yy"
    });

    $("#to").datepicker({
        dateFormat: "dd/mm/yy"
    });
</script>
@stop