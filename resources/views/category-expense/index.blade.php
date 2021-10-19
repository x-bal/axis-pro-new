@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5" style="font-size: 18px;">
                    <div>
                        {{ __('Category Expense List') }}
                    </div>
                    <div>
                        <a href="{{ route('category-expense.create') }}" class="btn btn-outline-info">Create</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resource as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_kategory }}</td>
                                <td>{{ $data->desc }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('category-expense.edit', $data->id) }}" class="btn btn-outline-warning">Edit</a>
                                        <form action="{{ route('category-expense.destroy', $data->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('anda yakin ingin menghapus kategori')" class="btn btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
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