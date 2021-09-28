<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="adjusted_idr">Adjusted IDR</label>
            <input name="adjusted_idr" id="adjusted_idr" type="text" value="{{ $feebased->adjusted_idr ?? '' }}" class="form-control @error('adjusted_idr') is-invalid @enderror">
            @error('adjusted_idr')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="adjusted_usd">Adjusted USD</label>
            <input name="adjusted_usd" id="adjusted_usd" type="text" value="{{ $feebased->adjusted_usd ?? '' }}" class="form-control @error('adjusted_usd') is-invalid @enderror">
            @error('adjusted_usd')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="fee_idr">Fee IDR</label>
            <input name="fee_idr" id="fee_idr" type="text" value="{{ $feebased->fee_idr ?? '' }}" class="form-control @error('fee_idr') is-invalid @enderror">
            @error('fee_idr')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="fee_usd">Fee USD</label>
            <input name="fee_usd" id="fee_usd" type="text" value="{{ $feebased->fee_usd ?? '' }}" class="form-control @error('fee_usd') is-invalid @enderror">
            @error('fee_usd')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="category_fee">Category Fee</label>
            <select name="category_fee" id="category_fee" type="text" class="form-control @error('category_fee') is-invalid @enderror">
                <option disabled selected>Select Category</option>
                <option value="1" {{ $feebased->category_fee == 1 ? 'selected' : ''}}>Marine</option>
                <option value="2" {{ $feebased->category_fee == 2 ? 'selected' : ''}}>Non Marine</option>
            </select>
            @error('category_fee')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>