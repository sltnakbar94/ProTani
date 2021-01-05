<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Perusahaan</th>
            <th>Expedisi</th>
            <th>Surat Jalan</th>
            <th>Nama Driver</th>
            <th>Plat Nomor</th>
            <th>Nomor Telepon</th>
            <th>Kuantitas</th>
            {{-- <th>Operator</th> --}}
            <th>Nomor Pengiriman</th>
            <th>Tujuan</th>
            <th>Kuantitas per tujuan</th>
            <th>URL</th>
            <th>Status Order</th>
            <th>Jumlah Diterima</th>
            <th>Nama Penerima</th>
            <th>HP Penerima</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Status Terima</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($datas as $data)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $data->perusahaan }}</td>
            <td>{{ $data->ekspedisi }}</td>
            <td>{{ $data->surat_jalan }}</td>
            <td>{{ $data->nama_driver }}</td>
            <td>{{ $data->plat }}</td>
            <td>{{ $data->phone }}</td>
            <td>{{ $data->qty }}</td>
            <?php
            // $user = DB::table('users')
            // ->where('id', 'LIKE', $data->user_id)
            // ->select('name')
            // ->first();
            ?>
            {{-- <td>{{ $user->name }}</td> --}}
            <td>{{ $data->orderDetail->nomor_order }}</td>
            <td>{{ $data->orderDetail->tujuan }}</td>
            <td>{{ $data->orderDetail->qty }}</td>
            <td>{{ $data->orderDetail->url }}</td>
            @if ($data->orderDetail->status_order == "1")
                <td>Sudah Diproses</td>
            @else
                <td>Belum Diproses</td>
            @endif
            <td>{{ $data->orderDetail->jumlah_diterima }}</td>
            <td>{{ $data->orderDetail->nama_penerima }}</td>
            <td>{{ $data->orderDetail->hp_penerima }}</td>
            <td>{{ $data->orderDetail->lat }}</td>
            <td>{{ $data->orderDetail->lng }}</td>
        </tr>
    @endforeach
    </tbody>
</table>