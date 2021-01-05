@extends(backpack_view('blank'))

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info text-center"><h4>DATA UPDATE {{ date('Y-m-d H:i:s') }}</h4></div>
        <div id="map_canvas" style="min-height: 600px; width: auto;">
    </div>
</div>

@endsection

@section('after_scripts')
    @include('dashboard.js.maps')
@endsection