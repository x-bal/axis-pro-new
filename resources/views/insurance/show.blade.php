@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-info">Back</a>
                    </div>
                    <div>
                        <h3>{{ $clients->name }}</h3>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">File No</th>
                                <th colspan="2">Invoice</th>
                                <th rowspan="2">Leader / Member</th>
                                <th rowspan="2">Member Share</th>
                                <th rowspan="2">Cause Of Lost</th>
                            </tr>
                            <tr>
                                <th>Rp</th>
                                <th>Usd</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients->share as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center"><a href="{{ route('case-list.show', $data->caselist->id) }}">{{ $data->caselist->file_no ?? 'Kosong' }}</a></td>
                                <td class="text-right">{{ $data->caselist->currency == 'RP' ? number_format($data->caselist->claim_amount) : ''}}</td>
                                <td class="text-right">{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->claim_amount) : '' }}</td>
                                <th class="text-center">{{ $data->is_leader ? 'Leader' : 'Member' }}</th>
                                <td class="text-center">{{ $data->share }}%</td>
                                <td>{{ $data->caselist->incident->type_incident ?? 'Kosong' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    $('.table').DataTable()
</script>
@stop