@extends('layouts.app')

@section('content')
<style>
    td {
        text-align: center;
        font-size: 10px;
        text-transform: uppercase;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                        <div>
                            {{ __($title . ' - (Pending)') }}
                        </div>
                        @can('case-list-create')
                        <a href="{{ route('case-list.create') }}" class="btn btn-admin"><i class="fas fa-pen"></i> Create</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped custom-table" width="100%" id="table">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <td rowspan="2" class="border" style="text-align: center; align-items: center;">No</td>
                                    <td rowspan="2" class="border">File No</td>
                                    <td rowspan="2" class="border">Initial Adj</td>
                                    <td colspan="3" class="text-center border-0">Insurance</td>
                                    <td rowspan="2" class="border">Leader</td>
                                    <td rowspan="2" class="border">Insured</td>
                                    <td rowspan="2" class="border">DOL</td>
                                    <td rowspan="2" class="border">Risk Location / Project</td>
                                    <td rowspan="2" class="border">Cause of Lost</td>
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
                                @foreach($cases as $case)
                                <tr>
                                    <td rowspan="2">{{ $loop->iteration }}</td>
                                    <td rowspan="2"><a href="{{ route('case-list.show', $case->id) }}">{{ $case->file_no }}</a></td>
                                    <td rowspan="2">{{ $case->adjuster->kode_adjuster }}</td>
                                    <td rowspan="2">{{ $case->insurance->name }}</td>
                                    <td rowspan="2">
                                        @foreach ($case->member as $member)
                                        {{ $member->share }} %
                                        @endforeach
                                    </td>
                                    <td rowspan="2">
                                        @foreach ($case->member as $member)
                                        {{ $member->is_leader == 1 ? 'Leader' : 'Member' }}
                                        @endforeach
                                    </td>
                                    <td rowspan="2">{{ $case->insurance->name }}</td>
                                    <td rowspan="2">{{ $case->insured }}</td>
                                    <td rowspan="2">{{ $case->dol }}</td>
                                    <td rowspan="2">{{ $case->risk_location }}</td>
                                    <td rowspan="2">{{ $case->incident->type_incident }}</td>
                                    <td rowspan="2">{{ $case->status->nama_status }}</td>
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
@endsection

@section('footer')
<script>
    $(".table").dataTable()
</script>
@stop