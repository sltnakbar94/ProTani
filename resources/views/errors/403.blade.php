@extends(backpack_view('layouts.plain-no-sticky'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">
            <!-- <h3 class="text-center mb-4">{{ trans('backpack::base.login') }}</h3> -->
            <h3 class="text-center mb-4 mt-3">
                <img src="/logo.png" alt="CMS" style="width:240px;height:auto;">
            </h3>
            <div class="alert alert-warning text-center">
              <h2>MAAF ANDA TIDAK MEMILIKI AKSES. SILAHKAN LOGIN KEMBALI!</h2>
            </div>
            <div class="text-center">
                <a href="/admin/login">Kembali ke halaman utama.
            </div>

            
        </div>
    </div>
@endsection
