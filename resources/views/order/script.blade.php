@push('after_scripts')
<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    document.getElementById('lat').value = position.coords.latitude;
    document.getElementById('lng').value = position.coords.longitude;
}

document.addEventListener('DOMContentLoaded', (event) => {
    getLocation()
});

$('body').on('change', '#province_id', function(){
    var province_id = $(this).val()
    // populate select regency_id
    var html = '';
    $.get('/api/regency?public_path=true&province_id=' + province_id, function(response){
        var data = response;
        var html = '<option value="">Pilih Kota</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        $('#regency_id').html(html);
        $('#district_id').html('<option value="">Pilih Kecamatan</option>');
    });
})

$('body').on('change', '#regency_id', function(){
    var regency_id = $(this).val()
    // populate select district_id
    var html = '';
    $.get('/api/district?public_path=true&regency_id=' + regency_id, function(response){
        var data = response;
        var html = '<option value="">Pilih Kecamatan</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        $('#district_id').html(html);
        $('#village_id').html('<option value="">Pilih Kelurahan</option>');
    });
})

$('body').on('change', '#district_id', function(){
    var district_id = $(this).val()
    // populate select village_id
    $.get('/api/village?public_path=true&district_id=' + district_id, function(response){
        var data = response;
        var html = '<option value="">Pilih Kelurahan</option>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
        }
        $('#village_id').html(html);
    });
})


</script>
@endpush
