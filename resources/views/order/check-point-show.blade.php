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
                            <div class="text-center"><strong>Status Pengiriman</strong></div>
                            <div>
                                <div class="alert alert-info text-center">Pengiriman ini telah diterima dan dilaporkan</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="nomor_order">Nomor Pengiriman</label>

                            <div>
                                <input type="text" class="form-control" name="nomor_order" id="nomor_order" value="{{ old('nomor_order', $order_detail->nomor_order) }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="tujuan">Tujuan</label>

                            <div>
                                <input type="text" class="form-control" name="tujuan" id="tujuan" value="{{ old('tujuan', $order_detail->tujuan) }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="nama_penerima">Nama Penerima</label>

                            <div>
                                <input type="text" class="form-control" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima', $order_detail->nama_penerima) }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="hp_penerima">HP Penerima</label>

                            <div>
                                <input type="text" class="form-control" name="hp_penerima" id="hp_penerima" value="{{ old('hp_penerima', $order_detail->hp_penerima) }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="jumlah_diterima">Jumlah Diterima</label>

                            <div>
                                <input type="number" class="form-control{{ $errors->has('jumlah_diterima') ? ' is-invalid' : '' }}" name="jumlah_diterima" name="jumlah_diterima" id="jumlah_diterima" value="{{ old('jumlah_diterima', $order_detail->qty) }}" readonly="readonly">
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
