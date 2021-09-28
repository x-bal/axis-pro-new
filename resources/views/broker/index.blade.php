@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Broker List') }}
                    </div>
                    @can('broker-access')
                    <a href="{{ route('broker.create') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Create</a>
                    @endcan
                </div>
                <table class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Broker Name</th>
                            <th>Telp</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brokers as $broker)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $broker->nama_broker }}</td>
                            <td>{{ $broker->telepon_broker }}</td>
                            <td>{{ $broker->email_broker }}</td>
                            <td>{{ $broker->alamat_broker }}</td>
                            <td>
                                @can('broker-edit')
                                <a href="{{ route('broker.edit', $broker->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('broker-edit')
                                <form action="{{ route('broker.destroy', $broker->id) }}" method="post" style="display: inline;" onclick="return confirm('Delete data?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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