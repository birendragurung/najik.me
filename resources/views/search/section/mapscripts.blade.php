<script>
    $(document).ready(function () {
        var el =
                '<div class="col-md-12 mt-5 mb-5 container">' +
                    '<div class="row">' +
                        '<span class="mb-5">Select distance</span> ' +
                        '<div id="map-distance-range">' +
                            '<div id="custom-handle" class="ui-slider-handle">' +
                        '</div>'+
                        '</div>' +
                        '<div class="">' +
                        '<input type="submit">'+
                '</div>'+
                    '</div>' +
                '</div>';
        $('#search-map').after(el);
        var handle = $("#custom-handle");

        $("#map-distance-range").slider({
            orientation: "horizantal",
            range: "min",
            min: 1,
            max: 20,
            value: 4,
            create: function() {
                handle.text( $( this ).slider( "value" ) );
            },
            slide: function( event, ui ) {
                handle.text( ui.value );
            }
//            slide: function (event, ui) {
//                $("#amount").val(ui.value);
//            }
        });
        $("#radius-show").val($("#map-distance-range").slider("value"));

    })
</script>
<script>
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.

    var map, infoWindow, LatLng;

    function initMap() {
        //LatLng for storing any old coordinates..
        LatLng         = {
            lat: {!! old('business_latitude') ?: 27.690497 !!} ,
            lng: {!! old('business_longitude') ?: 83.465111 !!}
        };
        LatLng         = (Object.keys(LatLng).length === 0 && LatLng.constructor === Object) ?
            {
                lat: 27.690497,
                lng: 83.465111
            } : LatLng;
        var mapOptions = {
            /*{
             "zoom": 16,
             "maxZoom": 17,
             "maxZoomOut": 3,
             "gridSize": 60,
             "scrollwheel": false,
             "center": ["27.6856802", "83.4743666"],
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
             }*/

            "zoom": 3,
            "maxZoom": 17,
            "maxZoomOut": 3,
            "gridSize": 60,
            "scrollwheel": false,
            "center": LatLng,
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

        map = new google.maps.Map(document.getElementById('search-map'), mapOptions);

        //Custom styles.
        //REF : http://logicify.github.io/jquery-locationpicker-plugin/

        $("#search-map").locationpicker({
            //set to default location when there's no previously defined/saved coordinates
            location: LatLng,
            radius: 0,
            {{isset($markerDraggableDisable)?$markerDraggableDisable:""}}

            inputBinding: {
                latitudeInput: $('#business-lat'),
                longitudeInput: $('#business-lon'),
                radiusInput: $('#map-radius'),
                locationNameInput: $('#property-address')
            }
        });

        // Try HTML5 geolocation.
        /*
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
        var rectangle;

        var mapProp = {
            center: new google.maps.LatLng(27.690497, 83.465111),
            zoom: 5,
            maxWidth: 1000,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        infoWindow  = new google.maps.InfoWindow({
            size: new google.maps.Size(150, 50),
            content: 'name'

        });
        //        var map = new google.maps.Map(document.getElementById("search-map"), mapProp);

        var bounds = new google.maps.LatLngBounds();

        $('.business-wrapper').each(function (index, element) {

            var businessId = $(this).attr('id');
//            console.log(businessId);
            var property   = $(this);
            var lat        = property.attr('lat');
            var lng        = property.attr('long');

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

            marker.addListener('mouseover', function () {
                this.infowindow.open(map, this);
            });

            // assuming you also want to hide the infowindow when user mouses-out
            marker.addListener('mouseout', function () {
                this.infowindow.close();
            });

            marker.addListener('click', function (e) {
                console.log(e);
//                map.setZoom(8);
//                map.setCenter(marker.getPosition());
                scroll_to($(this));
                businessHighlight($(this));
            });
//            marker.addListener('mouseup', function (e) {
//                console.log(index);
//                $($('.business-wrapper')[index]).tooltip({
//                    classes: {
//                        "ui-tooltip": "highlight"
//                    }
//                })
//            });
            bounds.extend(marker.getPosition());

        });

        map.fitBounds(bounds);

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABa3_QsifCyHhVppeEPPElKetaSh9Wkhs&callback=initMap"></script>

