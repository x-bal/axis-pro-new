@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size: 18px;">
                {{ __('Create Case') }}
                <a href="{{ route('case-list.index') }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('case-list.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('case-list.form')
                    <button type="submit" class="btn btn-primary float-right" id="submit_case_list">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
