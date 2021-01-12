<!-- Modal -->
<div class="modal fade" id="addModalSalesFormDetail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addModalSalesFormDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalSalesFormDetailLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="form-modal-alert" style="display:none;">Data telah tersimpan</div>
        <form action="{{ route('salesformdetail.store') }}" enctype="multipart/form-data" method="post" name="sales_form_detail_add" id="sales-form-detail-add">
            @csrf
            <input type="hidden" name="sales_form_id" value="{{ $crud->entry->id }}">

            <div class="form-group">
                <label class="control-label" for="pool_number">Nomor Kolam</label>
@php
    $count = DB::table('sales_form_details')->where('sales_form_id', '=', $crud->entry->id)->count();
@endphp
                <div>
                    <input type="number" class="form-control{{ $errors->has('pool_number') ? ' is-invalid' : '' }}" name="pool_number" name="pool_number" id="pool_number" value="{{ $count+1 }}" required>

                    @if ($errors->has('pool_number'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('pool_number') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="pool_large">Luas Kolam</label>
                <div>
                    <input type="number" class="form-control{{ $errors->has('pool_large') ? ' is-invalid' : '' }}" name="pool_large" value="{{ old('pool_large') }}" required>
                    @if ($errors->has('pool_large'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('pool_large') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="fish_type">Jenis Ikan</label>
                <div>
                    <input type="text" class="form-control{{ $errors->has('fish_type') ? ' is-invalid' : '' }}" name="fish_type" value="{{ old('fish_type') }}" required>
                    @if ($errors->has('fish_type'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('fish_type') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="plant_date">Mulai Penaburan</label>
                <div>
                    <input type="date" class="form-control{{ $errors->has('plant_date') ? ' is-invalid' : '' }}" name="plant_date" value="{{ old('plant_date') }}" required>
                    @if ($errors->has('plant_date'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('plant_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="harvest_date">Tanggal Panen</label>
                <div>
                    <input type="date" class="form-control{{ $errors->has('harvest_date') ? ' is-invalid' : '' }}" name="harvest_date" value="{{ old('harvest_date') }}" required>
                    @if ($errors->has('harvest_date'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('harvest_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="harvest_qty">Target Panen</label>
                <div>
                    <input type="number" class="form-control{{ $errors->has('harvest_qty') ? ' is-invalid' : '' }}" name="harvest_qty" value="{{ old('harvest_qty') }}" required>
                    @if ($errors->has('harvest_qty'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('harvest_qty') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="result">Hasil Panen</label>
                <div>
                    <input type="text" class="form-control{{ $errors->has('result') ? ' is-invalid' : '' }}" name="result" value="{{ old('result') }}" required>
                    @if ($errors->has('result'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('result') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="sitepict">Foto</label>
                <div>
                    <input type="file" name="sitepict" accept="image/*" capture="user" class="form-control{{ $errors->has('sitepict') ? ' is-invalid' : '' }}">
                    @if ($errors->has('sitepict'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('sitepict') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group" style="display:none;">
                <label class="control-label" for="province_id">province_id</label>
                <div>
                    <input type="text" class="form-control" name="province_id" id="province_id" value="{{ $crud->entry->province_id }}" readonly="readonly">
                </div>
            </div>
            <div class="form-group" style="display:none;">
                <label class="control-label" for="regency_id">regency_id</label>
                <div>
                    <input type="text" class="form-control" name="regency_id" id="regency_id" value="{{ $crud->entry->regency_id }}" readonly="readonly">
                </div>
            </div>
            <div class="form-group" style="display:none;">
                <label class="control-label" for="district_id">district_id</label>
                <div>
                    <input type="text" class="form-control" name="district_id" id="district_id" value="{{ $crud->entry->district_id }}" readonly="readonly">
                </div>
            </div>
            <div class="form-group" style="display:none;">
                <label class="control-label" for="village_id">village_id</label>
                <div>
                    <input type="text" class="form-control" name="village_id" id="village_id" value="{{ $crud->entry->village_id }}" readonly="readonly">
                </div>
            </div>
            <div class="form-group" style="display:none;">
                <label class="control-label" for="lat">Latitude</label>
                <div>
                    <input type="text" class="form-control" name="lat" id="lat" value="{{ old('lat') }}" readonly="readonly">
                </div>
            </div>

            <div class="form-group" style="display:none;">
                <label class="control-label" for="lng">Longitude</label>
                <div>
                    <input type="text" class="form-control" name="lng" id="lng" value="{{ old('lng') }}" readonly="readonly">
                </div>
            </div>
            <div class="form-group text-right">
                <label for=""></label>
                <button type="button" class="btn btn-default">RESET</button>
                <button type="submit" class="btn btn-primary" id="add-buton-kolam">SIMPAN</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>
