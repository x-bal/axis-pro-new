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
                                    <td class="border" style="text-align: center; align-items: center;">No</td>
                                    <td class="border">File No</td>
                                    <td class="border">Initial Adj</td>
                                    <td class="border">Name</td>
                                    <td class="border">Share</td>
                                    <td class="border">Leader / Member</td>
                                    <td class="border">Leader</td>
                                    <td class="border">Insured</td>
                                    <td class="border">DOL</td>
                                    <td class="border">Risk Location / Project</td>
                                    <td class="border">Cause of Lost</td>
                                    <!-- <td class="border">Claim of Amount</td>
                            <td class="border">Instruction Date</td> -->
                                    <td class="border">Status</td>
                                </tr>
                                <tr>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($cases as $case)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('case-list.show', $case->id) }}">{{ $case->file_no }}</a></td>
                                    <td>{{ $case->adjuster->kode_adjuster }}</td>
                                    <td>{{ $case->insurance->name }}</td>
                                    <td>
                                        @foreach ($case->member as $member)
                                        {{ $member->share }} %
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($case->member as $member)
                                        {{ $member->is_leader == 1 ? 'Leader' : 'Member' }}
                                        @endforeach
                                    </td>
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