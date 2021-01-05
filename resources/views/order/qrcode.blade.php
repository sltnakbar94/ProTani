<div style="border:1px solid black;padding: 10px;width:180px;height:auto;">
    {!! QrCode::size(180)->generate(route('qrcode-form', $url)) !!}
    <center><a href="{{ route('qrcode-form', $url) }}">{{ $order_detail->nomor_order }}</a></center>
    <center>Call Center: <br> 0852-2342-0833 <br> 0819-3066-5227</center>
</div><br>
<!-- <div style="border:1px solid black;padding: 10px;width:180px;height:auto;">
{!! QrCode::size(180)->generate(route('recipient-form')) !!}
<br> 
<center>PENERIMA BANSOS</center>
</div> -->

<script>
window.print()
</script>