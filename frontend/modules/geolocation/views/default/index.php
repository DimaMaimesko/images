<div class="geolocation-default-index">
    
</div>

<h1>My First Google Map</h1>

<hr>


<p id="demoWatch">Click the button to get your position.</p>
<button onclick="getLocationWatch()">Watch It</button>
<div id="mapholderWatch" style="height:100%"></div>
<p id="demo-textWatch"></p>
<button onclick="zoomPlus()">+</button>
<button onclick="zoomMinus()">-</button>

<script>
    var zoomVar = 12;
    function zoomPlus(){
        zoomVar = zoomVar + 1; 
        getLocationWatch();
    }
    function zoomMinus(){
        zoomVar = zoomVar - 1; 
        getLocationWatch();
    }
    
var x3 = document.getElementById("demoWatch");

function getLocationWatch() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionWatch);
        navigator.geolocation.getCurrentPosition(showTextPositionWatch);
        console.log("Hi");
        } else {
        x3.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPositionWatch(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    var latlon = new google.maps.LatLng(lat, lon);
    var mapholder = document.getElementById('mapholderWatch');
    mapholder.style.height = '500px';
    mapholder.style.width = '100%';

    var myOptions = {
    center:latlon,zoom:zoomVar,
    mapTypeId:google.maps.MapTypeId.SATELLITE,
    mapTypeControl:false,
    navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
    };

    var map = new google.maps.Map(document.getElementById("mapholderWatch"), myOptions);
    
    var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!",animation:google.maps.Animation.BOUNCE});
    marker.setMap(map);
     var infowindow = new google.maps.InfoWindow({
     content: "Hello World!"
     });
    infowindow.open(map,marker);
  
  // Zoom to 9 when clicking on marker
  google.maps.event.addListener(marker,'click',function() {
    map.setZoom(10);
    map.setCenter(marker.getPosition());
  });
 
  
  google.maps.event.addListener(map, 'click', function(evt){
            console.log(evt.latLng.lat().toFixed(5));
            console.log( evt.latLng.lng().toFixed(5));
  });
  
}
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x3.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x3.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x3.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x3.innerHTML = "An unknown error occurred."
            break;
    }
}
var x4 = document.getElementById("demo-textWatch");
function showTextPositionWatch(position) {
    x4.innerHTML = "Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude;
}



</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSC2Eca-gleFwSuaLBMMLePnCXoOxoHoo&callback=getLocationWatch"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSC2Eca-gleFwSuaLBMMLePnCXoOxoHoo&callback=myMap"></script>-->



