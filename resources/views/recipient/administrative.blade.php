<div class="form-group">
    <label class="control-label" for="district_id">Kecamatan</label>

    <div>
        <select name="district_id" id="district_id" class="form-control{{ $errors->has('district_id') ? ' is-invalid' : '' }}" required>
            <option value="">Pilih Kecamatan</option>
        </select>
        @if ($errors->has('district_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('district_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label class="control-label" for="village_id">Kelurahan</label>

    <div>
        <select name="village_id" id="village_id" class="form-control{{ $errors->has('village_id') ? ' is-invalid' : '' }}" required>
            <option value="">Pilih Kelurahan</option>
        </select>
        @if ($errors->has('village_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('village_id') }}</strong>
            </span>
        @endif
    </div>
</div>