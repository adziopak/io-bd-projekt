function initMap() {
    var buildings = ::jsBuildings::;

    var c = {lat: buildings[0]['lat'], lng: buildings[0]['lon']};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: c
    });
    
    buildings.forEach(function (item, index) {

        var position = { lat: item['lat'], lng: item['lon']};

        var marker = new google.maps.Marker({
            position: position,
            map: map,
            title: item['name'],
            label: 'Budynek' + item['name']
        });

        marker.addListener('click', function() {
            window.location.replace('/building/show?name=' + item['name'] + '&floor=0');
        });
    });
}