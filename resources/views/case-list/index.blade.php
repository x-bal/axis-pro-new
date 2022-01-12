@extends('layouts.app')

@section('content')
<style>
    td {
        text-align: center;
        font-size: 10px;
        text-transform: uppercase;
    }
</style>

<div class="row justify-content-center">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Case List') }}
                    </div>
                    @can('case-list-create')
                    <div>
                        <a href="{{ route('caselist.restore') }}" class="btn btn-warning"><i class="fab fa-creative-commons-sa"></i> Restore</a>
                        <a href="{{ route('case-list.create') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Create</a>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <form action="{{ route('caselist.laporan') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="from" id="from" class="form-control @error('from') is-invalid @enderror" autocomplete="off" placeholder="dd/mm/yyyy">
                                    @error('from')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="to" id="to" class="form-control @error('to') is-invalid @enderror" autocomplete="off" placeholder="dd/mm/yyyy">
                                    @error('to')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    @if(auth()->user()->hasRole('admin'))
                                    <select name="adjuster" id="adjuster" class="form-control">
                                        <option value="All">All</option>
                                        @foreach($adjuster as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama_lengkap }} - {{ $list->email }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <select name="status" id="status" class="form-control">
                                        <option value="All">All</option>
                                        @foreach($status as $stt)
                                        <option value="{{ $stt->id }}">{{ $stt->nama_status }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                            @if(auth()->user()->hasRole('admin'))
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="all">All</option>
                                        <option value="outstanding">Outstanding</option>
                                        <option value="5">Close File</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive-xl">
                        <table class="table table-bordered table-striped custom-table" width="100%" id="table">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" class="border-0">Detail</td>
                                    <td rowspan="2" class="border" style="text-align: center; align-items: center;">No</td>
                                    <td rowspan="2" class="border">File No</td>
                                    <td rowspan="2" class="border">Initial Adj</td>
                                    <td colspan="3" class="text-center border-0">Insurance</td>
                                    <td rowspan="2" class="border">Leader</td>
                                    <td rowspan="2" class="border">Insured</td>
                                    <td rowspan="2" class="border">DOL</td>
                                    <td rowspan="2" class="border">Risk Location / Project</td>
                                    <td rowspan="2" class="border">Cause of Loss</td>
                                    <!-- <td rowspan="2" class="border">Claim of Amount</td>
                            <td rowspan="2" class="border">Instruction Date</td> -->
                                    <td rowspan="2" class="border">Status</td>
                                    @can('case-list-edit')
                                    <td rowspan="2" class="border">Action</td>
                                    @endcan
                                </tr>
                                <tr>
                                    <td class="border">Name</td>
                                    <td class="border">Share</td>
                                    <td class="border">Leader / Member</td>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    let table = new DataTable('#table', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('case-list.index') }}",
            data: function(d) {
                d.status = $('#status').val(),
                    d.search = $('input[type="search"]').val()
            },
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'fileno',
                name: 'fileno'
            },
            {
                data: 'initial',
                name: 'initial'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'share',
                name: 'share'
            },
            {
                width: '10%',
                data: 'is_leader',
                name: 'is_leader'
            },
            {
                data: 'leader',
                name: 'leader'
            },
            {
                data: 'insured',
                name: 'insured'
            },
            {
                data: 'dol',
                name: 'dol'
            },
            {
                data: 'risk_location',
                name: 'risk_location'
            },
            {
                data: 'cause',
                name: 'cause'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',

            },

        ],
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
        orderable: true,
        searchable: true
    });



    $(document).ready(function() {
        $("#status").on('change', function() {
            table.draw()
        })

        $("#from").datepicker({
            dateFormat: "dd/mm/yy"
        });

        $("#to").datepicker({
            dateFormat: "dd/mm/yy"
        });

    })
</script>
@stop