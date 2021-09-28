<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="type_policy">Type Policy</label>
            <input name="type_policy" id="type_policy" type="text" value="{{ $policy->type_policy ?? '' }}" class="form-control @error('type_policy') is-invalid @enderror">
            @error('type_policy')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="abbreviation">Abbreviation</label>
            <input name="abbreviation" id="abbreviation" type="text" value="{{ $policy->abbreviation ?? '' }}" class="form-control @error('abbreviation') is-invalid @enderror">
            @error('abbreviation')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>