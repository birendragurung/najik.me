
<script>
    function businessHighlight(element) {
        $(element).effect("highlight", {}, 5000);
    }
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
        LatLng = {lat: {{$address->latitude}} , lng: {{$address->longitude}} };
        @endif
                LatLng  =(Object.keys(LatLng).length === 0 && LatLng.constructor === Object) ? {
            lat: 27.690497,
            lng: 83.465111
        } : LatLng;
        map = new google.maps.Map(document.getElementById('search-map'), {
            //If previous request has lat and lng values, use that value else use default lat lng value
            //REF: https://stackoverflow.com/questions/679915/how-do-i-test-for-an-empty-javascript-object
            center: LatLng,
            zoom: 16
        });
        infoWindow = new google.maps.InfoWindow;

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
        {{--@if(count($businesses)>0)--}}
        {{--@foreach($businesses as $business)--}}
        {{--$("#search-map").locationpicker({--}}
            {{--//set to default location when there's no previously defined/saved coordinates--}}
            {{--location: { latitude : {{$business->address->latitude  }} , longitude : {{$business->address->longitude  }}  },--}}
            {{--radius: 0,--}}
            {{--{{isset($markerDraggableDisable)?$markerDraggableDisable:""}}--}}

            {{--inputBinding: {--}}
                {{--latitudeInput: $('#business-lat'),--}}
                {{--longitudeInput: $('#business-lon'),--}}
                {{--radiusInput: $('#map-radius'),--}}
                {{--locationNameInput: $('#property-address')--}}
            {{--}--}}
{{--//            customStyles : customStyles,--}}

{{--//            markerIcon: 'img/map_pointer.png',--}}
        {{--});--}}
        {{--@endforeach--}}
        {{--@endif--}}
{{--

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
--}}

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
<script>

    function initMapPicker() {
// This example adds a user-editable rectangle to the map.
// When the user changes the bounds of the rectangle,
// an info window pops up displaying the new bounds.

        var rectangle;

        var mapProp = {
            center: new google.maps.LatLng(51.508742, -0.120850),
            zoom: 5,
            maxWidth: 1000,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("search-map"), mapProp);

        var bounds = new google.maps.LatLngBounds();

        $('.business-wrapper').each( function (index,element) {

            var businessId = $(this).attr('id');
//            console.log(businessId);
            var property = $(this);
            var lat      = property.attr('lat');
            var lng      = property.attr('long');

            var image = "http://najikme.dev/img/map-pin.png";


            var marker = new google.maps.Marker({
//                icon: image,
                map: map,
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(lat, lng)
            });

//            map.addListener('center_changed', function() {
//                // 3 seconds after the center of the map has changed, pan back to the
//                // marker.
//                window.setTimeout(function() {
//                    map.panTo(marker.getPosition());
//                }, 3000);
//            });

            marker.addListener('click', function(e) {
                console.log(e);
//                map.setZoom(8);
//                map.setCenter(marker.getPosition());
                scroll_to($('.business-wrapper')[index]);
                businessHighlight($('.business-wrapper')[index]);
            });
            marker.addListener('mouseup', function (e) {
                console.log(index);
                $($('.business-wrapper')[index]).tooltip({
                    classes: {
                        "ui-tooltip": "highlight"
                    }
                })
            });
            bounds.extend(marker.getPosition());

        });

        map.fitBounds(bounds);


//$.each(property, function (i) {
//    property[i].addEventListener("mouseover", function () {
//        lat = $(this).attr('lat');
//        lng = $(this).attr('long');
//
//        console.log("lat:" + lat + " " + "Lng:" + lng);
//
//        var marker = new google.maps.Marker({
//            icon: image,
//            map: map,
//            animation: google.maps.Animation.DROP,
//            position: new google.maps.LatLng(lat, lng)
//        });
//
//    });
//
//});

    }

    initMapPicker();
</script>

