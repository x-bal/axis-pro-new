@extends('layouts.app', ['title' => 'Permissions'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Permissions</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('permission.store') }}" method="post">
            @csrf
            @include('permission.form')
        </form>
    </div>
</div>
@stop