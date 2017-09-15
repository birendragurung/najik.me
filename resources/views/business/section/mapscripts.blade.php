<script>

    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.
    var map, infoWindow, LatLng;

    function initMap() {
        //LatLng for storing any old coordinates..
        LatLng = {
            lat: {!! old('business_latitude') ?: 27.690497 !!} ,
            lng: {!! old('business_longitude') ?: 83.465111 !!}
        };

        @if(isset($address))
        //This is for the editbusiness blade file where address of the business is passed to this blade
        LatLng     = {lat: {{$address->latitude}} , lng: {{$address->longitude}} };
        @endif
            LatLng = (Object.keys(LatLng).length === 0 && LatLng.constructor === Object) ? {
            lat: 27.690497,
            lng: 83.465111
        } : LatLng;

        //Custom styles.
        //REF : http://logicify.github.io/jquery-locationpicker-plugin/
        var customStyles = [{
            "elementType": "geometry",
            "stylers": [{"hue": "#ff4400"}, {"saturation": -68}, {"lightness": -4}, {"gamma": 0.72}]
        }, {"featureType": "road", "elementType": "labels.icon"}, {
            "featureType": "landscape.man_made",
            "elementType": "geometry",
            "stylers": [{"hue": "#0077ff"}, {"gamma": 3.1}]
        }, {
            "featureType": "water",
            "stylers": [{"hue": "#00ccff"}, {"gamma": 0.44}, {"saturation": -33}]
        }, {
            "featureType": "poi.park",
            "stylers": [{"hue": "#44ff00"}, {"saturation": -23}]
        }, {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{"hue": "#007fff"}, {"gamma": 0.77}, {"saturation": 65}, {"lightness": 99}]
        }, {
            "featureType": "water",
            "elementType": "labels.text.stroke",
            "stylers": [{"gamma": 0.11}, {"weight": 5.6}, {"saturation": 99}, {"hue": "#0091ff"}, {"lightness": -86}]
        }, {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{"lightness": -48}, {"hue": "#ff5e00"}, {"gamma": 1.2}, {"saturation": -23}]
        }, {
            "featureType": "transit",
            "elementType": "labels.text.stroke",
            "stylers": [{"saturation": -64}, {"hue": "#ff9100"}, {"lightness": 16}, {"gamma": 0.47}, {"weight": 2.7}]
        }];
        var mapOptions = {
            "zoom": 14,
            "center": new google.maps.LatLng(LatLng),
            "styles": [{"featureType": "poi", "stylers": [{"visibility": "off"}]}, {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#444444"}]
            }, {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{"color": "#f2f2f2"}]
            }, {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{"saturation": -100}, {"lightness": 45}]
            }, {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{"visibility": "simplified"}]
            }, {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            }, {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]
            }]
        };
        console.log('LatLng  :' + LatLng);
        map        = new google.maps.Map(document.getElementById('map'), mapOptions);
        infoWindow = new google.maps.InfoWindow();

        $("#map").locationpicker({
            //set to default location when there's no previously defined/saved coordinates
            location:{latitude:map.getCenter().lat(),longitude:map.getCenter().lng()},
            radius: 0,
            inputBinding: {
                latitudeInput: $('#business-lat'),
                longitudeInput: $('#business-lon'),
                radiusInput: $('#map-radius'),
                locationNameInput: $('#property-address')
            }
//            customStyles : customStyles,

//            markerIcon: 'img/map_pointer.png',
        });

        /*
         // Try HTML5 geolocation.
         if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function (position) {
         var pos = {
         lat: position.coords.latitude,
         lng: position.coords.longitude
         };

         infoWindow.setPosition(pos);
         infoWindow.setContent('Location found.');
         infoWindow.open(map);
         map.setCenter(pos);
         }, function () {
         handleLocationError(true, infoWindow, map.getCenter());
         });
         } else {
         // Browser doesn't support Geolocation
         handleLocationError(false, infoWindow, map.getCenter());
         }
         */
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABa3_QsifCyHhVppeEPPElKetaSh9Wkhs&callback=initMap"></script>