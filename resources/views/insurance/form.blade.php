<div class="form-group row">
    <div class="col-md-2">
        <label for="brand">Brand</label>
    </div>
    <div class="col-md-10">
        <input name="brand" id="brand" type="text" value="{{ $client->brand ?? old('brand') }}" class="form-control @error('brand') is-invalid @enderror">
        @error('brand')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <label for="name">Nama</label>
    </div>

    <div class="col-md-10">
        <input name="name" id="name" type="text" value="{{ $client->name ?? old('name') }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <label for="address">Alamat</label>
    </div>

    <div class="col-md-10">
        <input name="address" id="address" type="text" value="{{ $client->address ?? old('address') }}" class="form-control @error('address') is-invalid @enderror">
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>


<div class="form-group row">
    <div class="col-md-2">
        <label for="no_telp">No Telp</label>
    </div>

    <div class="col-md-10">
        <input name="no_telp" id="no_telp" type="text" value="{{ $client->no_telp ?? old('no_telp') }}" class="form-control @error('no_telp') is-invalid @enderror">
        @error('no_telp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <label for="no_hp">No HP</label>
    </div>

    <div class="col-md-10">
        <input name="no_hp" id="no_hp" type="text" value="{{ $client->no_hp ?? old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror">
        @error('no_hp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-2">
        <label for="email">Email</label>
    </div>

    <div class="col-md-10">
        <input name="email" id="email" type="text" value="{{ $client->email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
