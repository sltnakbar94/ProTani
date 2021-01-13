<!-- Modal -->
<div class="modal fade" id="editModalSalesFormDetail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editModalSalesFormDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalSalesFormDetailLabel">Ubah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data" name="form_sales_form_detail_edit" id="form-sales-form-detail-edit">
            @csrf
            <input type="hidden" name="sales_form_id" value="{{ $crud->entry->id }}">

            <div class="form-group">
                <label class="control-label" for="pool_number">Nomor Kolam</label>
                <div>
                    <input type="number" class="form-control{{ $errors->has('pool_number') ? ' is-invalid' : '' }}" name="pool_number" name="pool_number" id="pool_number" value="{{ old('pool_number') }}" required>

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
                <label class="control-label" for="result">Hasil</label>
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
            <div class="form-group text-right">
                <label for=""></label>
                <button type="submit" class="btn btn-warning"><i class="fa edit"></i> UBAH</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>
