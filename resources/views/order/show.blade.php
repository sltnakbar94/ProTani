@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
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
	    <div class="card no-padding no-border">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-right">Tanggal Kirim: <strong>{{ $crud->entry->created_at->format('d F Y') }}</strong></h6><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="table">
                            <table class="table no-border">
                                @php
                                    $province = DB::table('provinces')->where('id', '=', $crud->entry->province_id)->first();
                                    $regency = DB::table('regencies')->where('id', '=', $crud->entry->regency_id)->first();
                                    $district = DB::table('districts')->where('id', '=', $crud->entry->district_id)->first();
                                    $village = DB::table('villages')->where('id', '=', $crud->entry->village_id)->first();
                                @endphp
                                <tr>
                                    <td>Nama Petani</td>
                                    <td><strong>{{ $crud->entry->farmer_name }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Nomor KTP</td>
                                    <td><strong>{{ $crud->entry->id_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>No Telp.</td>
                                    <td><strong>{{ $crud->entry->phone_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>{{ $crud->entry->id_address }}, RT:{{ $crud->entry->rt }}/RW:{{ $crud->entry->rw }}, {{ $village->name }}, {{ $district->name }}, {{ $regency->name }}</td>
                                </tr>
                                <tr>
                                    <td>Provinsi</td>
                                    <td>{{ $province->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table">
                            <table class="table no-border">
                                <tr>
                                    <td>Foto KTP</td>
                                    <td><img src="{{asset('storage/public/'.$crud->entry->idpict)}}" style="width:100%"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
        <div class="card no-padding no-border">
            <div class="card-header">
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
                                    <th style="width: 15%">Foto</th>
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
                                        @if ($od->sitepict != NULL)
                                            <td><img src="{{asset('storage/'.$od->sitepict)}}" style="width:100%"></td>
                                        @else
                                            <td></td>
                                        @endif
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
                                    <td colspan="9" class="text-center">Belum ada data kolam</td>
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
