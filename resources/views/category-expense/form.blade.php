<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="nama_kategory">Category Name</label>
            <input type="text" id="nama_kategory" class="form-control @error('nama_kategory') is-invalid @enderror" name="nama_kategory" value="{{ $resource->nama_kategory ?? old('nama_kategory') }}">
            @error('nama_kategory')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="desc">Description</label>
            <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ $resource->desc ?? old('desc') }}</textarea>
            @error('desc')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>