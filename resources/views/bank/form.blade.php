<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input name="bank_name" id="bank_name" type="text" value="{{ $bank->bank_name ?? '' }}" class="form-control @error('bank_name') is-invalid @enderror">
            @error('bank_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="no_account">No Account</label>
            <input name="no_account" id="no_account" type="text" value="{{ $bank->no_account ?? '' }}" class="form-control @error('no_account') is-invalid @enderror">
            @error('no_account')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="currency">Currency</label>
            <select name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror">
                <option disabled selected>Select Currency</option>
                <option value="RP" {{ $bank->currency == 'RP' ? 'selected' : '' }}>RP</option>
                <option value="USD " {{ $bank->currency == 'USD' ? 'selected' : '' }}>USD</option>
            </select>
            @error('currency')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>