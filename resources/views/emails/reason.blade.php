@extends('layouts.app')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card"></div>
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

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection