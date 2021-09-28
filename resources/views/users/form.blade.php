<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input name="nama_lengkap" id="nama_lengkap" type="text" value="{{ $user->nama_lengkap ?? '' }}" class="form-control @error('nama_lengkap') is-invalid @enderror">
            @error('nama_lengkap')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" id="email" type="text" value="{{ $user->email ?? '' }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="no_telepon">Phone</label>
            <input name="no_telepon" id="no_telepon" type="text" value="{{ $user->no_telepon ?? '' }}" class="form-control @error('no_telepon') is-invalid @enderror">
            @error('no_telepon')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="kode_adjuster">Kode Adjuster</label>
            <input name="kode_adjuster" id="kode_adjuster" type="text" value="{{ $user->kode_adjuster ?? '' }}" class="form-control @error('kode_adjuster') is-invalid @enderror">
            @error('kode_adjuster')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
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

    <div class="col-md-4">
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role[]" id="role" class="form-control select2" multiple="multiple">
                @foreach($user->roles as $rol)
                <option selected value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            @error('role')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>