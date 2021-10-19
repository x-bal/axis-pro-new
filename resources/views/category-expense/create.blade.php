@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size: 18px;">
                {{ __('Create Category Expense') }}
                <a href="{{ route('category-expense.index') }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('category-expense.store') }}" method="post">
                    @csrf
                    @include('category-expense.form')
                    <button type="submit" class="btn btn-primary float-right">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection