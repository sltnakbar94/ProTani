<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script>
      var map;
      var Markers = {};
      var infowindow;

      var locations = {!! json_encode($locations) !!}
      var origin = { lat: -6.428577, lng: 106.802957 }

      function initialize() {
        var mapOptions = {
          zoom: 10,
          center: origin
        };

        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
            map: map
          });

          google.maps.event.addListener(marker, 'click', (function(marker, i, content) {
            return function() {
              var contentString = '<div id="content">'+
              '<div id="siteNotice">'+
              '</div>'+
              '<h6 id="firstHeading" class="firstHeading">Form ID: '+ locations[i].sales_form_id +' </h6>'+
              '<div id="bodyContent">'+
              '<p>Luas Kolam: '+ locations[i].pool_large +' <br>' +
              'Jenis Ikan: '+ locations[i].fish_type +' <br>' +
              'Tanggal Penaburan: '+ locations[i].plant_date +'<br>' +
              'Target Panen: '+ locations[i].harvest_date +'<br>' +
              'Jumlah Panen: '+ locations[i].harvest_qty +'<br>' +
              // 'Detail: <a href="'+ locations[i].url +'">Lihat Detail</a>'+
              '</div>'+
              '</div>';

              infowindow.setContent(contentString);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }

      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
