@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="font-size: 18px;">
                {{ __('Profile') }}
                <a href="{{ route('dashboard') }}" class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update', $user->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input name="nama_lengkap" id="nama_lengkap" type="text" value="{{ $user->nama_lengkap ?? old('nama_lengkap') }}" class="form-control @error('nama_lengkap') is-invalid @enderror">
                                @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" id="email" type="text" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" readonly disabled>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_telepon">Phone</label>
                                <input name="no_telepon" id="no_telepon" type="number" value="{{ $user->no_telepon ?? old('no_telepon') }}" class="form-control @error('no_telepon') is-invalid @enderror">

                                @error('no_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" id="password" type="password" value="" class="form-control @error('password') is-invalid @enderror">

                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    $(".select2").select2()
</script>
@stop