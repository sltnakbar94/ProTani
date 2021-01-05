@extends(backpack_view('layouts.plain-no-sticky'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <!-- <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3> -->
            <h3 class="text-center mb-4 mt-3">
                <img src="/logo.png" alt="CMS" style="width:240px;height:auto;">
            </h3>
            <div class="alert alert-info text-center">
                <h4>TERIMA KASIH {{ $recipient->name }}</h4>
            </div>
        </div>
    </div>
@endsection