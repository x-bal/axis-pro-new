@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between p-2">
                    <a href="{{ route('insurance.index') }}" class="btn btn-outline-info">Back</a>

                    <h5>Insurance List</h5>
                </div>
                <form action="{{ route('insurance.update', $client->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    @include('insurance.form')
                    <button type="submit" class="btn btn-outline-success float-right">Store</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection