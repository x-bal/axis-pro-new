@extends('layouts.app', ['title' => 'Permissions'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Permission List') }}
                    </div>
                    @can('permission-create')
                    <a href="{{ route('permission.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Permission</a>
                    @endcan
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @can('permission-edit')
                                    <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('permission-delete')
                                    <form action="{{ route('permission.destroy', $permission->id) }}" method="post" style="display: inline;" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
@stop

@section('footer')
<script>
    $(".table").DataTable()
</script>
@stop