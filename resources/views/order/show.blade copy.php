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
                        <h6 class="text-right">Tanggal Kirim: <strong>{{ $crud->entry->tanggal_kirim->format('d F Y') }}</strong></h6><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="table"> 
                            <table class="table no-border">
                                <tr>
                                    <td>Perusahaan</td>
                                    <td>{{ $crud->entry->perusahaan }}</td>
                                </tr>
                                <tr>
                                    <td>Ekpedisi</td>
                                    <td>{{ $crud->entry->ekspedisi }}</td>
                                </tr>
                                <tr>
                                    <td>Surat Jalan</td>
                                    <td>{{ $crud->entry->surat_jalan }}</td>
                                </tr>
                                <tr>
                                    <td>Driver</td>
                                    <td>{{ $crud->entry->nama_driver }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Polisi</td>
                                    <td>{{ $crud->entry->plat }}</td>
                                </tr>
                                <tr>
                                    <td>HP Driver</td>
                                    <td>{{ $crud->entry->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Total Jumlah</td>
                                    <td>{{ number_format($crud->entry->qty) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <button data-toggle="modal" data-target="#modal-order-detail" class="btn btn-primary" style="width:200px;height:200px;font-size:28px;"><i class="fa fa-plus"></i> TAMBAH POD</button>
                    </div>
                    <!-- <div class="col-md-6">
                        <div id="map-container" style="width:100%;height:400px;" class="text-center">
                            <div id="map_canvas" style="height:400px;"></div>
                        </div>
                    </div> -->
                </div>
            </div>
	    </div>
        <div class="card no-padding no-border">
            <div class="card-header">   
                <div class="row">
                    <div class="col-md-12">
                        <div class="table">
                            <table class="table">
                                <tr>
                                    <th>Nomor Pengiriman</th>
                                    <th>Tujuan</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Action</th>
                                </tr>
                                @if(isset($crud->entry->order_details))
                                    @foreach($crud->entry->order_details as $od)
                                    <tr>
                                        <td>{{ $od->nomor_order }}</td>
                                        <td>{{ $od->tujuan }}</td>
                                        <td>{{ $od->qty }}</td>
                                        <td>{{ $od->created_at->format('d-m-y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-secondary">QRCODE</button>
                                                <button type="button" class="btn btn-secondary">EDIT</button>
                                                <button type="button" class="btn btn-secondary">DELETE</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data order</td>
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

<!-- Modal -->
<div class="modal fade" id="modal-order-detail" tabindex="-1" role="dialog" aria-labelledby="modal-order-detailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-order-detailLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
    <script>    
        var marker = null;
        var map = null;

        function initialize() {
            var lat = {!! $crud->entry->lat !!}
            var lng = {!! $crud->entry->lng !!}
            var oldlocation = { lat: lat, lng: lng };

            map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 16,
                center: oldlocation,
                draggable: false,
                disableDefaultUI: true
            });

            addMarker(oldlocation, map)
        }

        function addMarker(location, map) {
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection
