@extends(backpack_view('layouts.plain-no-sticky'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <!-- <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3> -->
            <h3 class="text-center mb-4 mt-3">
                <img src="/logo.png" alt="CMS" style="width:240px;height:auto;">
            </h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('qrcode-submit', $order_detail->url) }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="nomor_order">Nomor Pengiriman</label>

                            <div>
                                <input type="text" class="form-control" name="nomor_order" id="nomor_order" value="{{ old('nomor_order', $order_detail->nomor_order) }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="nama_penerima">Nama Penerima</label>

                            <div>
                                <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="hp_penerima">HP Penerima</label>

                            <div>
                                <input type="text" class="form-control" name="hp_penerima" id="hp_penerima" value="{{ old('hp_penerima') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="jumlah_diterima">Jumlah Diterima</label>

                            <div>
                                <input type="number" class="form-control{{ $errors->has('jumlah_diterima') ? ' is-invalid' : '' }}" name="jumlah_diterima" name="jumlah_diterima" id="jumlah_diterima" value="{{ old('jumlah_diterima', $order_detail->qty) }}">

                                @if ($errors->has('jumlah_diterima'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('jumlah_diterima') }}</strong>
                                    </span>
                                @endif
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
        
                        <div class="form-group">
                            <label class="control-label" for="qty">Foto KTP</label>

                            <div>
                                <input type="file" name="foto_ktp" accept="image/*" capture="user" class="form-control{{ $errors->has('foto_ktp') ? ' is-invalid' : '' }}">
                                @if ($errors->has('foto_ktp'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('foto_ktp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-success">
                                    SIMPAN
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    document.getElementById('lat').value = position.coords.latitude;
    document.getElementById('lng').value = position.coords.longitude;
}

document.addEventListener('DOMContentLoaded', (event) => {
    getLocation()
});

</script>
@endpush
