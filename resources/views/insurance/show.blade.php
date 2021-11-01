@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('insurance.index') }}" class="btn btn-info">Back</a>
                    </div>
                    <div>
                        <h3>{{ $clients->name }}</h3>
                    </div>
                </div>
                <hr>

                <div class="table-responsive">
                    <form action="{{ route('insurance.laporan',$clients->id) }}" method="post">
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
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="outstanding">Outstanding</option>
                                        <option value="5">Close File</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">File No</th>
                                <th colspan="2">Invoice</th>
                                <th rowspan="2">Leader / Member</th>
                                <th rowspan="2">Member Share</th>
                                <th rowspan="2">Cause Of Lost</th>
                                <th rowspan="2">Instruction Date</th>
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
                                <td class="text-right">{{ $data->caselist->currency == 'IDR' ? number_format($data->caselist->claim_amount) : ''}}</td>
                                <td class="text-right">{{ $data->caselist->currency == 'USD' ? number_format($data->caselist->claim_amount) : '' }}</td>
                                <th class="text-center">{{ $data->is_leader ? 'Leader' : 'Member' }}</th>
                                <td class="text-center">{{ $data->share }}%</td>
                                <td>{{ $data->caselist->incident->type_incident ?? 'Kosong' }}</td>
                                <td>{{ $data->caselist->instruction_date }}</td>
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