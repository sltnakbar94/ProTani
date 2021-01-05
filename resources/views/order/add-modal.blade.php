<!-- Modal -->
<div class="modal fade" id="addModalOrderDetail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addModalOrderDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalOrderDetailLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" id="form-modal-alert" style="display:none;">Data telah tersimpan</div>
        <form action="{{ route('orderdetail.store') }}" method="post" name="form_order_detail_add" id="form-order-detail-add">
            @csrf
            <input type="hidden" name="order_id" value="{{ $crud->entry->id }}">

            <div class="form-group">
                <label class="control-label" for="nomor_order">Nomor Pengiriman</label>

                <div>
                    <input type="hidden" name="shipper" value="{{ $crud->entry->ekspedisi }}">
                    <input type="text" class="form-control{{ $errors->has('nomor_order') ? ' is-invalid' : '' }}" name="nomor_order" name="nomor_order" id="nomor_order" value="AUTO GENERATE" required readonly="readonly">

                    @if ($errors->has('nomor_order'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('nomor_order') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label" for="tujuan">Tujuan</label>
                <div>
                    <select name="tujuan" id="tujuan" class="form-control{{ $errors->has('tujuan') ? ' is-invalid' : '' }}" required>
                        @foreach(\App\Models\Destination::pluck('name', 'name') as $value => $text)
                            @if($crud->entry->destination)
                                @if(in_array($value, $crud->entry->destination->destinations->pluck('name')->toArray()))
                                <option value="{{ $text }}" {{ old('tujuan') == $text ? "selected": ""  }}>{{ $text }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('tujuan'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('tujuan') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="qty">Jumlah</label>
                <div>
                    <input type="number" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" value="{{ old('qty') }}" required>
                    <p class="help-block" style="font-size:80%;">Usahakan jangan scroll kolom dengan mouse karena nilai akan berubah.</p>
                    @if ($errors->has('qty'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('qty') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="">Pre-Order</label>
                <input type="checkbox" name="pre_order" id="pre_order">
            </div>
            <div class="form-group text-right">
                <label for=""></label>
                <button type="button" class="btn btn-default">RESET</button>
                <button type="submit" class="btn btn-primary" id="add-buton-pod">SIMPAN</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>