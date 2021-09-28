@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Cause Of Loss List') }}
                    </div>
                    <a href="{{ route('cause-of-loss.create') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Create</a>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Type Incident</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incidents as $incident)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $incident->type_incident }}</td>
                            <td>{{ $incident->description }}</td>
                            <td>
                                <a href="{{ route('cause-of-loss.edit', $incident->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('cause-of-loss.destroy', $incident->id) }}" method="post" style="display: inline;" onclick="return confirm('Delete data?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
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