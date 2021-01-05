<div class="row">
    <div class="col-md-10">  
        <div class="table table-responsive">
            <table class="table table-bordered bg-white table-striped thead-light" style="width:100%;">
                <tr>
                    <th>Kota</th>
                    <th>Ekspedisi</th>
                    <th>Kuota Paket</th>
                    <th>Paket Keluar</th>
                    <th>Paket Diterima</th>
                    <th>Sisa Paket</th>
                </tr>
                @foreach($kpms as $kpm)
                    <tr>
                        <td>{{ $kpm['name'] }}</td>
                        <td>{{ $kpm['expedition'] }}</td>
                        <td class="text-right">{{ number_format($kpm['quota']) }}</td>
                        <td class="text-right">{{ number_format($kpm['data']['paket_keluar']) ?: 0 }}</td>
                        <td class="text-right">{{ number_format($kpm['data']['paket_diterima']) ?: 0 }}</td>
                        <td class="text-right">{{ number_format($kpm['quota'] - $kpm['data']['paket_keluar']) ?: 0 }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
