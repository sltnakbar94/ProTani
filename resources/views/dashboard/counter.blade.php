<div class="row" name="widget_899479116" section="before_content">

    <div class="col-md-2">
        <div class="card text-white bg-primary mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['total_produksi']['count']) }}</div>

                <div>Total Produksi</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['total_produksi']['progress'] }}%" 
                      aria-valuenow="{{ $dashboard['total_produksi']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

    <div class="col-md-2">
        <div class="card text-white bg-secondary mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['stok_paket']['count']) }}</div>

                <div>Stok Paket</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['stok_paket']['progress'] }}%"
                        aria-valuenow="{{ $dashboard['stok_paket']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

    <div class="col-md-2" data-toggle="modal" data-target="#showModalPaketKeluar">
        <div class="card text-white bg-warning mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['paket_keluar']['count']) }}</div>

                <div>Paket Keluar</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['paket_keluar']['progress'] }}%"
                        aria-valuenow="{{ $dashboard['paket_keluar']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

    <div class="col-md-2" data-toggle="modal" data-target="#showModalPaketDikirim">
        <div class="card text-white bg-danger mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['sedang_dikirim']['count']) }}</div>

                <div>Sedang Dikirim</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['sedang_dikirim']['progress'] }}%"
                        aria-valuenow="{{ $dashboard['sedang_dikirim']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

    <div class="col-md-2" data-toggle="modal" data-target="#showModalPaketDitujuan">
        <div class="card text-white bg-success mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['sampai_ketujuan']['count']) }}</div>

                <div>Sampai Ketujuan</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['sampai_ketujuan']['progress'] }}%"
                        aria-valuenow="{{ $dashboard['sampai_ketujuan']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

</div>