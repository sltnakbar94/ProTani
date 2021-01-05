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
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('recipient-submit') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="control-label" for="nama">Nama Penerima</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" id="nama" value="{{ old('nama') }}" required>
                                 @if ($errors->has('nama'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="nik">NIK</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" id="nik" value="{{ old('nik') }}" required>
                                @if ($errors->has('nik'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('nik') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="regency_id">Kota</label>

                            <div>
                                <select name="regency_id" id="regency_id" class="form-control{{ $errors->has('regency_id') ? ' is-invalid' : '' }}" required>
                                    <option value="">Pilih Kota</option>
                                    @foreach(\App\Models\Regency::whereIn('id', [3271, 3275, 3671, 3674, 3276])->get() as $regency)
                                    <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('regency_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('regency_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @include('recipient.administrative')

                        <div class="form-group">
                            <label class="control-label" for="alamat">Alamat</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" id="alamat" value="{{ old('alamat') }}" required>
                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="control-label" for="rt">RT</label>

                                <div>
                                    <input type="text" class="form-control{{ $errors->has('rt') ? ' is-invalid' : '' }}" name="rt" id="rt" value="{{ old('rt') }}" required>
                                    @if ($errors->has('rt'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('rt') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col">
                                <label class="control-label" for="rw">RW</label>

                                <div>
                                    <input type="text" class="form-control{{ $errors->has('rw') ? ' is-invalid' : '' }}" name="rw" id="rw" value="{{ old('rw') }}" required>
                                    @if ($errors->has('rw'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('rw') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="control-label" for="kode_pos">Kode Pos</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('kode_pos') ? ' is-invalid' : '' }}" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" required>
                                @if ($errors->has('kode_pos'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('kode_pos') }}</strong>
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
                            <label class="control-label" for="qty">Foto</label>

                            <div>
                                <input type="file" name="foto" accept="image/*" capture="user" class="form-control{{ $errors->has('foto') ? ' is-invalid' : '' }}">
                                @if ($errors->has('foto'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('foto') }}</strong>
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

$('body').on('change', '#regency_id', function(){
    var regency_id = $(this).val()
    // populate select district_id
    var html = '';
    $.get('/api/district?public_path=true&regency_id=' + regency_id, function(response){
        var data = response;
        var html = '<option value="">Pilih Kecamatan</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        $('#district_id').html(html);
        $('#village_id').html('<option value="">Pilih Kelurahan</option>');
    });
})

$('body').on('change', '#district_id', function(){
    var district_id = $(this).val()
    // populate select village_id
    $.get('/api/village?public_path=true&district_id=' + district_id, function(response){
        var data = response;
        var html = '<option value="">Pilih Kelurahan</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        $('#village_id').html(html);
    });
})


</script>
@endpush
