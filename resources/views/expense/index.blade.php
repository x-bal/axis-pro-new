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
                                    <input type="date" name="from" id="from" class="form-control @error('from') is-invalid @enderror">
                                    @error('from')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="to" id="to" class="form-control @error('to') is-invalid @enderror">
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
                        <table class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>File No</th>
                                    <th>Adjuster</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expense as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('case-list.show',$data->caselist->id) }}">{{ $data->caselist->file_no }}</a></td>
                                    <td>{{ $data->adjuster }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                                    <th class="text-right">{{ number_format($data->amount) }}</th>
                                    <th class="text-right">{{ number_format($data->total) }}</th>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning" onclick="expenseedit(this)" data-id="{{ $data->id }}" data-toggle="modal" data-target="#exampleModalCenter">Edit</button>
                                            <button type="button" class="btn btn-primary" onclick="expenselog(this)" data-id="{{ $data->id }}" data-toggle="modal" data-target="#exampleModalLong">Log</button>
                                            <form action="{{ route('expense.destroy',$data->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" onclick="return confirm('Anda Yakin Ingin Menghapus Expense')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
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
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    function expenseedit(qr) {
        $('#id_expense').val($(qr).attr('data-id'))
    }

    function expenselog(qr) {
        let id = $(qr).attr('data-id')
        $('#logtable').DataTable({
            serverSide: true,
            processing: true,
            destroy: true,
            order: [[4,'desc']],
            ajax: `/api/admin/expense/log/${id}`,
            columns: [
                {
                    data: 'id',
                    name: 'id'
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
</script>
@stop