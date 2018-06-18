<div class="geolocation-default-index">
    
</div>

<h1>My Second Google Map (Travercy)</h1>
<style>
    #map{
        height:400px;
        width: 100%;
    }
</style>
<hr>



<div id="map"></div>

<script>
    function initMap(){
        var options = {
            zoom:8,
            center:{lat:46.47747,lng:30.73262},
            fullscreenControl:true,
            zoomControl:true,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        
        var map = new google.maps.Map(document.getElementById("map"),options);
//        var marker = new google.maps.Marker({
//                    map:map,
//                    position:{lat:46.97128478949575,lng:31.956130851562534},
//                    animation:google.maps.Animation.BOUNCE,
//                    icon:"/img/markers/MapMarker1.png"
//        });
//        var infoWindow = new google.maps.InfoWindow({
//            content:"<h3>This is Nikolaev</h3>",
//            position:{lat:46.97128478949575,lng:31.956130851562534}
//        });
//        google.maps.event.addListener(marker,"click",function(){
//            infoWindow.open(map,marker);
//        });
        
        var markers = [
            {
            coords:{lat:46.47747,lng:30.74262},
            iconImage:"/img/markers/MapMarker1.png",
            animation:google.maps.Animation.BOUNCE,
            info:"Helo!"
            },
            {
            coords:{lat:47.47747,lng:31.74262},
            iconImage:"/img/markers/MapMarker2Orange.png"
            },
            {
            coords:{lat:48.47747,lng:32.74262},
            iconImage:"/img/markers/MapMarker3Green.png",
            info:"Good Bye!"
            }
        ]
        for (var i = 0; i < markers.length; i++){
            addMarker(markers[i]);
        }

        function addMarker(params){
            var marker = new google.maps.Marker({
                    map:map,
                    position:params.coords
                    });
            if (params.iconImage){
                marker.setIcon(params.iconImage);
            }        
            if (params.animation){
                 marker.setAnimation(params.animation);
            }        
            if (params.info){
                 var infoWindow = new google.maps.InfoWindow({
                    content:params.info
                    });
                 google.maps.event.addListener(marker, "click", function () {
                                infoWindow.open(map, marker);
                            });
            }  
         
        }
        
        google.maps.event.addListener(map, "dblclick", function (event){
            addMarker({
            coords:event.latLng,
            iconImage:"/img/markers/MapMarker3Green.png",
            info:"Lat:"+event.latLng.lat()+"<br>Lon:"+event.latLng.lng()
            });
          
        });
        google.maps.event.addListener(map, "click", function (event){
           console.log(event.latLng.lat());
           console.log(event.latLng.lng());
        });
              
    }
   

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSC2Eca-gleFwSuaLBMMLePnCXoOxoHoo&callback=initMap"></script>




