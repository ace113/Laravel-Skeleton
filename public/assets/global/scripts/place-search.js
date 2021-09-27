$('document').ready(function () {
    geoLocation.initMap();
    geoLocation.findLocation();
});

let geoLocation = {
    $map: '',

    /**
     * Initialise google map
     */
    initMap: function () {
        let __this = this;
        let defaultLatitude = document.getElementById('latitude').value;
        let defaultlongitude = document.getElementById('longitude').value;

        defaultLatitude = defaultLatitude.length == 0 ? -33.791070 : defaultLatitude;
        defaultlongitude = defaultlongitude.length == 0 ? 151.005985 : defaultlongitude;

        let mapOptions = {
            center: new google.maps.LatLng(defaultLatitude, defaultlongitude),
            mapTypeControl: true,
            mapTypeControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,

            panControl: true,
            panControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            zoom: 14,
            maxZoom: 16
        };

        __this.map = new google.maps.Map(document.getElementById('map'), mapOptions);

        let marker = new google.maps.Marker({
            position: mapOptions.center,
        });

        // To add the marker to the map, call setMap();
        marker.setMap(__this.map);
    },

    /**
     * Google place api code below.
     * Also triggers loadProperty based on url parameter
     * @type {Element}
     */
    findLocation: function () {
        let __this = this;

        let latitudeInputField = document.getElementById('latitude');
        let longitudeInputField = document.getElementById('longitude');

        let placesInput = document.getElementById('searchPlace');

        let placesOptions = {
            // define restrictions
            componentRestrictions: {
                country: 'au'
            },
        };
        let autocomplete = new google.maps.places.Autocomplete(placesInput, placesOptions);

        google.maps.event.addDomListener(placesInput, 'keydown', function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            let place_lat = '';
            let place_lng = '';
            let lat_lon = '';
            let locationDetials = autocomplete.getPlace().formatted_address;
            console.log(locationDetials);

            if (typeof autocomplete.getPlace().geometry != 'undefined') {
                place_lat = autocomplete.getPlace().geometry.location.lat();
                place_lng = autocomplete.getPlace().geometry.location.lng();
                lat_lon = place_lat + ',' + place_lng;

                // update latLng value into hidden input filed for further processing
                latitudeInputField.value = place_lat;
                longitudeInputField.value = place_lng;                
            }

            if (typeof (lat_lon) != 'undefined') {
                let location = new google.maps.LatLng(parseFloat(place_lat), parseFloat(place_lng));
                __this.map.setCenter(location);
                map.zoom = 14;
                let bounds = __this.map.getBounds();
                ne_lat = bounds.getNorthEast().lat();
                sw_lat = bounds.getSouthWest().lat();
                sw_lon = bounds.getSouthWest().lng();
                ne_lon = bounds.getNorthEast().lng();

                __this.map.fitBounds(autocomplete.getPlace().geometry.viewport);


                let marker = new google.maps.Marker({
                    position: location,
                });

                // To add the marker to the map, call setMap();
                marker.setMap(__this.map);

                zoomChangeBoundsListener =
                    google.maps.event.addListenerOnce(map, 'bounds_changed', function (event) {
                        if (this.getZoom()) {
                            this.setZoom(12);
                        }
                    });
                setTimeout(function () {
                    google.maps.event.removeListener(zoomChangeBoundsListener)
                }, 2000);
            }

        });
    }
}
