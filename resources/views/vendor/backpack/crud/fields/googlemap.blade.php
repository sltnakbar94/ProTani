<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <input
        type="hidden"
        name="{{ $field['name'] }}"
        id="{{ $field['name'] }}"
        value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
        @include('crud::fields.inc.attributes')
    >
    <div id="{{ $field['name'] }}-map-container" style="width:100%;height:400px;" class="text-center">
        <div id="map_canvas" style="height:400px;"></div>
    </div>
    <script>

    var marker = null;
    var map = null;

    function initialize() {
        var oldlocation = { lat: -6.190397, lng: 106.797725 };

        if(document.getElementById("{{ $field['name'] }}").value != '')
        {
            var obj = JSON.parse(document.getElementById("{{ $field['name'] }}").value);
            var obj = JSON.parse(obj.map);

            if(typeof obj === 'object')
            {
                var oldlocation = { lat: obj.lat, lng: obj.lng };
            }
        }
        map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 16,
            center: oldlocation
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
        // This event listener calls addMarker() when the map is clicked.
        google.maps.event.addListener(map, 'click', function(event) {
            if (marker) {
                marker.setMap(null);
                marker = null;
            }
            addMarker(event.latLng, map);
        });
        // Add a marker fron the beginig
        addMarker(oldlocation, map);
        
    }

    // Adds a marker to the map.
    function addMarker(location, map) {
        // Add the marker at the clicked location, and add the next-available label
        // from the array of alphabetical characters.
        marker = new google.maps.Marker({
            position: location,
            map: map
        });

        var values = {
            "lat": location.lat(),
            "lng": location.lng()
        }

        //!TODO Set To Attributes Form Maybe
        document.querySelector("input[name=lat]").value = location.lat()
        document.querySelector("input[name=lng]").value = location.lng()
        document.getElementById("{{ $field['name'] }}").value = JSON.stringify(values);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

      @push('crud_fields_styles')
          <style>
            #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
          </style>
      @endpush

  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

      @push('crud_fields_scripts')
          <!-- no scripts -->
          <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
      @endpush
@endif