

function createMap(currentHost){
    var map;
    var posMaldonado;
    var posSanCarlos;
    var markerMaldonado;
    var markerSanCarlos;
    var element_id = "map-canvas";

    posMaldonado = new google.maps.LatLng(-34.911484,-54.954557);

    var styledMapOptions  = {name: "deleon"};
    var featureOpts = [
    {featureType: "water",           elementType: "geometry",            stylers: [{color: "#004E63"}]},
    {featureType: "road.arterial",    elementType: "geometry",            stylers: [{color: "#E0B196"}]},
    {featureType: "road.highway",     elementType: "geometry",            stylers: [{color: "#E0B196"}]},
    {featureType: "road.arterial",    elementType: "geometry.stroke",     stylers: [{color: "#D18D65"}]},
    {featureType: "road.highway",     elementType: "geometry.stroke",     stylers: [{color: "#D18D65"}]},
    {featureType: "road.arterial",    elementType: "labels.text.stroke",  stylers: [{color: "#E0B196"}]},
    {featureType: "road.highway",     elementType: "labels.text.stroke",  stylers: [{color: "#E0B196"}]},
    {featureType: "road.arterial",    elementType: "labels.text.fill",    stylers: [{color: "#222222"}]},
    {featureType: "road.highway",     elementType: "labels.text.fill",    stylers: [{color: "#222222"}]},
    {featureType: "poi.park",         elementType: "all",                 stylers: [{saturation: -73 }]},
    {featureType: "landscape",        elementType: "geometry",            stylers: [{color: "#E4E6EB"}]}
    ];


    var mapOptions = {  scrollwheel: false,
    zoom: 16,
    center: posMaldonado,
    disableDefaultUI: true,
    zoomControl: true,
    mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'deleon'] }
    };


    map = new google.maps.Map(document.getElementById(element_id), mapOptions);

    customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

    map.mapTypes.set('deleon', customMapType);
    map.setMapTypeId('deleon');
    var marker_image = new google.maps.MarkerImage(currentHost + 'img/pin.png', new google.maps.Size(40, 54), new google.maps.Point(0,0));

    markerMaldonado = new google.maps.Marker({ position: posMaldonado,
    map: map,
    icon: marker_image });

    markerSanCarlos = new google.maps.Marker({  position: posSanCarlos,
    map: map,
    icon: marker_image });

    $("#set-mark-1").click(function() {
    map.setCenter(posMaldonado);
    });


}