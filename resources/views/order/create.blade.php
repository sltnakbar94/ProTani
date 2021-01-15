@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

    $form_id = DB::table('sales_forms')->count();
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">

	<!-- Default box -->
	  <div class="">
	  	@if ($crud->model->translationEnabled())
	    <div class="row">
	    	<div class="col-md-12 mb-2">
				<!-- Change translation button group -->
				<div class="btn-group float-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
			</div>
	    </div>
	    @else
	    @endif
	    <div class="card no-padding no-border col-md-10">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center"><strong>DATA PETANI</strong></h3><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table">
                            <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('salesform.store') }}" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group" style="display:none;">
                                    <label class="control-label" for="form_id">Form ID</label>

                                    <div>
                                        <input type="text" class="form-control" name="form_id" id="form_id" value="{{ $form_id+1 }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label class="control-label" for="user_id">User</label>

                                    <div>
                                        <input type="text" class="form-control" name="user_id" id="user_id" value="{{ Auth::id() }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="farmer_name">Nama Petani</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('farmer_name') ? ' is-invalid' : '' }}" farmer_name="farmer_name" id="farmer_name" value="{{ old('farmer_name') }}" required>
                                        @if ($errors->has('farmer_name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('farmer_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="id_number">NIK</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('id_number') ? ' is-invalid' : '' }}" name="id_number" id="id_number" value="{{ old('id_number') }}" required>
                                        @if ($errors->has('id_number'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('id_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="phone_number">No HP</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required>
                                        @if ($errors->has('phone_number'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="province_id">Provinsi</label>

                                    <div>
                                        <select name="province_id" id="province_id" class="form-control{{ $errors->has('province_id') ? ' is-invalid' : '' }}" required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach(\App\Models\Province::get() as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('province_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('province_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @include('recipient.administrative')

                                <div class="form-group">
                                    <label class="control-label" for="id_address">Alamat</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('id_address') ? ' is-invalid' : '' }}" name="id_address" id="id_address" value="{{ old('id_address') }}" required>
                                        @if ($errors->has('id_address'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('id_address') }}</strong>
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
                                    <label class="control-label" for="site_address">Lokasi Kolam</label>

                                    <div>
                                        <input type="text" class="form-control{{ $errors->has('site_address') ? ' is-invalid' : '' }}" name="site_address" id="site_address" value="{{ old('site_address') }}" required>
                                        @if ($errors->has('site_address'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('site_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="idpict">Foto</label>

                                    <div>
                                        <input type="file" name="idpict" accept="image/*" capture="user" class="form-control{{ $errors->has('idpict') ? ' is-invalid' : '' }}">
                                        @if ($errors->has('idpict'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('idpict') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="description">Catatan</label>

                                    <div>
                                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" value="{{ old('description') }}" required></textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('description') }}</strong>
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
                                {{-- @include('order.script') --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
        <div class="card no-padding no-border col-md-10">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center"><strong>DATA KOLAM</strong></h3><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModalSalesFormDetail">
                            <i class="fa fa-plus"></i> TAMBAH KOLAM
                            </button>
                        <br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table">
                            <table class="table table-responsive">
                                <tr>
                                    <th style="width: 10%">Nomor Kolam</th>
                                    <th style="width: 10%">Luas Kolam</th>
                                    <th style="width: 15%">Jenis Ikan</th>
                                    <th style="width: 10%">Mulai Penaburan</th>
                                    <th style="width: 10%">Tanggal Panen</th>
                                    <th style="width: 10%">Target Panen</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                                @if(isset($crud->entry->sales_form_details))
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach($crud->entry->sales_form_details as $od)
                                    @php
                                    $total += $od->qty;
                                    @endphp
                                    <tr>
                                        <td>{{ number_format($od->pool_number) }}</td>
                                        <td>{{ number_format($od->pool_large) }}</td>
                                        <td>{{ $od->fish_type }}</td>
                                        <td>{{ Carbon\Carbon::parse($od->plant_date)->format('d-m-Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($od->harvest_date)->format('d-m-Y') }}</td>
                                        <td>{{ number_format($od->harvest_qty) }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a id="{{ route('salesformdetail.edit', $od->id) }}" href="{{ route('salesformdetail.update', $od->id) }}" class="btn btn-warning editModalSalesFormDetail" data-toggle="modal" data-target="#editModalSalesFormDetail">EDIT</a>
                                                @if($od->status_terima != 1)
                                                <form method="POST" action="{{ route('salesformdetail.destroy', $od->id) }}" class="js-confirm" data-confirm="Apakah anda yakin ingin menghapus data ini?">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <th>TOTAL</th>
                                        <th>{{ $total }}</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data kolam</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	  </div>
	</div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('packages/backpack/crud/js/show.js') }}"></script>

    <script>

        function getLocation() {
        if (navigator.geolocation) {
            console.log(navigator.geolocation.getCurrentPosition(showPosition))
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
        }

        function showPosition(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('lng').value = position.coords.longitude;
        }

        $('body').on('change', '#province_id', function(){
            var province_id = $(this).val()
            // populate select regency_id
            var html = '';
            $.get('/api/regency?public_path=true&province_id=' + province_id, function(response){
                var data = response;
                var html = '<option value="">Pilih Kota</option>';
                for(var count = 0; count < data.length; count++)
                {
                html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                }
                $('#regency_id').html(html);
                $('#district_id').html('<option value="">Pilih Kecamatan</option>');
            });
        })

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

        $(document).ready(function(){
            $('body').on('submit', '#sales_form_detail_add', function(e){
                e.preventDefault();

                $('#add-buton-kolam').attr('disabled', true)

                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success:function(response){
                        if(response.success) {
                            // close modal
                            // show notification
                            // reload
                            $("#sales_form_detail_add").trigger('reset');
                            $("#addModalSalesFormDetail").modal('hide');
                            window.open(response.url, '_blank');
                            window.location.reload();
                        }
                    },
                    error:function(xhr, responseText, throwError){
                        if(xhr.responseJSON.success === false) {
                            $('#form-modal-alert').show();
                            $('#form-modal-alert').html(xhr.responseJSON.message);
                            $('#add-buton-kolam').attr('disabled', false)
                        }
                    },
                });

                return false;
            })

            $('body').on('click', '.editModalSalesFormDetail', function(){
                var edit_url = $(this).attr('id');
                var url = $(this).attr('href');

                $('#form-sales-form-detail-edit').attr('action', url);

                $.ajax({
                    url: edit_url,
                    type: 'GET',
                    dataType: 'json',
                    data: {},
                    success:function(response){
                        console.log(response)
                        $('body').find('input[name=pool_number]').val(response.pool_number)
                        $('body').find('input[name=pool_large]').val(response.pool_large)
                        $('body').find('input[name=fish_type]').val(response.fish_type)
                        $('body').find('input[name=plant_date]').val(response.plant_date)
                        $('body').find('input[name=harvest_date]').val(response.harvest_date)
                        $('body').find('input[name=harvest_qty]').val(response.harvest_qty)
                        $('body').find('input[name=result]').val(response.result)
                        $('body').find('input[name=sitepict]').val(response.sitepict)
                    },
                    error:function(xhr, responseText, throwError){
                        console.log('error!')
                    },
                });

            });

            $('body').on('submit', '#form-sales-form-detail-edit', function(e){
                e.preventDefault();

                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'PUT',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success:function(response){
                        if(response.success) {
                            // close modal
                            // show notification
                            // reload
                            $("#form-sales-form-detail-edit").trigger('reset');
                            $("#editModalSalesFormDetail").modal('hide');
                            window.location.reload();
                        }
                    },
                    error:function(xhr, responseText, throwError){
                        if(xhr.responseJSON.success === false) {
                            $('#form-modal-alert').show();
                            $('#form-modal-alert').html(xhr.responseJSON.message);
                        }
                    },
                });

                return false;
            })

            $('body').on('change keyup keypress', 'form', function(e){
                $('#form-modal-alert').hide();
                $('#form-modal-alert').html('');
            });

            $(document.body).on('submit', '.js-confirm', function () {
                var $el = $(this)
                var text = $el.data('confirm') ? $el.data('confirm') : 'Anda yakin melakukan tindakan ini ?'

                var c = confirm(text);
                return c;
            });


            getLocation();
        });

    </script>
@endsection
