<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJUWQzA_autLm7DQXea0qPR2usGP2qDkc&callback=initMap" async></script>
<script>
    let map, activeInfoWindow, markers = [];

    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 50.062315941267734,
                lng: 19.938156253355654,
            },
            zoom: 14
        });

        map.addListener("click", function(event) {
            mapClicked(event);
        });

        initMarkers();
    }

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers() {
        const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

        for (let index = 0; index < initialMarkers.length; index++) {

            const markerData = initialMarkers[index];
            const marker = new google.maps.Marker({
                position: markerData.position,
                label: markerData.label,
                draggable: markerData.draggable,
                map
            });
            markers.push(marker);

            const infowindow = new google.maps.InfoWindow({
                content: `<b><b>${markerData.name}</b></b><br>${markerData.address}`,
            });
            marker.addListener("click", (event) => {
                if(activeInfoWindow) {
                    activeInfoWindow.close();
                }
                infowindow.open({
                    anchor: marker,
                    shouldFocus: false,
                    map
                });
                activeInfoWindow = infowindow;
                markerClicked(marker, index);
            });
        }
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked(event) {
        console.log(map);
        console.log(event.latLng.lat(), event.latLng.lng());
    }

    /* ------------------------ Handle Marker Click Event ----------------------- */
    function markerClicked(marker, index) {
        console.log(map);
        console.log(marker.position.lat());
        console.log(marker.position.lng());
    }

</script>
