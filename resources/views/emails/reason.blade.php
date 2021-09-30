@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="{{ asset('asset/logo.png') }}" alt="" srcset="">
                    </div>
                    <form method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <label for="reason">{{ __('Reason') }}</label>

                            <textarea name="reason" id="reason" rows="3" class="form-control @error('email') is-invalid @enderror" autofocus></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Send') }}
                        </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection