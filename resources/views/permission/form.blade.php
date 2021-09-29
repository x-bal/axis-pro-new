<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name ?? old('name') }}">
    @error('name')
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
    @enderror
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>