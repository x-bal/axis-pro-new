@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Insurance List') }}
                    </div>
                    @can('insurance-access')
                    <a href="{{ route('insurance.create') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Create</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Brand</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Hp</th>
                                <th>Email</th>
                                <!-- <th>Status</th> -->
                                <th>PPN</th>
                                <!-- <th>Type</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $client->brand }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->no_telp }}</td>
                                <td>{{ $client->no_hp }}</td>
                                <td>{{ $client->email }}</td>
                                <!-- <td>{{ $client->status }}</td> -->
                                <td>{{ $client->ppn }}%</td>
                                <!-- <td>{{ $client->type }}</td> -->
                                <td>
                                    @can('insurance-edit')
                                    <a href="{{ route('insurance.edit', $client->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('insurance-delete')
                                    <form action="{{ route('insurance.destroy', $client->id) }}" method="post" style="display: inline;" onclick="return confirm('Delete data?')">
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
</div>
@endsection

@section('footer')
<script>
    $('.table').DataTable()
</script>
@stop