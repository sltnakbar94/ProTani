<div class="row" name="widget_899479116" section="before_content">

    <div class="col-md-6">
        <div class="card text-white bg-cyan mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['petani']['count']) }}</div>

                <div>Total Petani</div>

                {{-- <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['petani']['progress'] }}%"
                      aria-valuenow="{{ $dashboard['petani']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div> --}}

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-white bg-orange mb-2 text-right">
            <div class="card-body">
                <div class="text-value">{{ number_format($dashboard['kolam']['count']) }}</div>

                <div>Total Kolam</div>

                {{-- <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $dashboard['kolam']['progress'] }}%"
                        aria-valuenow="{{ $dashboard['kolam']['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div> --}}

                <small class="text-muted"></small>
            </div>

        </div>
    </div>

</div>

