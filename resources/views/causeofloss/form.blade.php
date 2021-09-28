<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="type_incident">Type Incident</label>
            <input name="type_incident" id="type_incident" type="text" value="{{ $incident->type_incident ?? '' }}" class="form-control @error('type_incident') is-invalid @enderror">
            @error('type_incident')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">Description</label>
            <input name="description" id="description" type="text" value="{{ $incident->description ?? '' }}" class="form-control @error('description') is-invalid @enderror">
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>