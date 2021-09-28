<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name</label>
            <input name="name" id="name" type="text" value="{{ $role->name ?? '' }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="permission">Permission</label>
            <select name="permission[]" id="permission" class="form-control @error('permission') is-invalid @enderror" multiple>
                @if($role->id)
                @foreach($rolePermissions as $perm)
                <option selected value="{{ $perm->id }}">{{ $perm->name }}</option>
                @endforeach
                @endif
                @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
            @error('permission')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>