@extends('layouts.app')

@section('content')
<style>
    th {
        text-align: center;
        font-size: 10px;
        text-transform: uppercase;
    }

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
                                    <th class="border" style="text-align: center; align-items: center;">No</th>
                                    <th class="border">File No</th>
                                    <th class="border">Initial Adj</th>
                                    <th class="border">Name</th>
                                    <!-- <th class="border">Share</th> -->
                                    <!-- <th class="border">Leader / Member</th> -->
                                    <th class="border">Leader</th>
                                    <th class="border">Insured</th>
                                    <th class="border">DOL</th>
                                    <th class="border">Risk Location / Project</th>
                                    <th class="border">Cause of Lost</th>
                                    <!-- <th class="border">Claim of Amount</th>
                            <th class="border">Instruction Date</th> -->
                                    <th class="border">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cases as $case)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('case-list.show', $case->id) }}">{{ $case->file_no }}</a></td>
                                    <td>{{ $case->adjuster->kode_adjuster }}</td>
                                    <td>{{ $case->insurance->name }}</td>
                                    <!-- <td>
                                        @foreach ($case->member as $member)
                                        {{ $member->is_leader == 1 && $case->insurance_id == $member->member_insurance ? $member->share : '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($case->member as $member)
                                        {{ $member->is_leader == 1 ? 'Leader' : 'Member' }}
                                        @endforeach
                                    </td> -->
                                    <td>{{ $case->insurance->name }}</td>
                                    <td>{{ $case->insured }}</td>
                                    <td>{{ $case->dol }}</td>
                                    <td>{{ $case->risk_location }}</td>
                                    <td>{{ $case->incident->type_incident }}</td>
                                    <td>{{ $case->status->nama_status }}</td>
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