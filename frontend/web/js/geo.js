 function initMap(){ 
     var options = {
                    zoom:10,
                    center:{lat:56.9683418,lng:12.01573409},
                    fullscreenControl:true,
                    zoomControl:true,
                    mapTypeId: google.maps.MapTypeId.SATELLITE,
                    disableDoubleClickZoom: true
                   };  
     
     var map = new google.maps.Map(document.getElementById("map"),options);
     var watchID = 0;
     //infoWindow = new google.maps.InfoWindow;
     var isItFirstTime = true;
     if (navigator.geolocation) {
           watchID = navigator.geolocation.watchPosition(showPosition);
           document.getElementById('textWatch').innerHTML = "Geolocation is OK.";
        } else {
           document.getElementById('textWatch').innerHTML = "Geolocation is not supported by this browser.";
    }
    
    var pos;
    var accuracy;
    var accurOut = document.getElementById('accuracyOut');
    var marker = new google.maps.Marker({
                                    map:map,
                                   // position:pos
                                    animation:google.maps.Animation.BOUNCE,
                                    });
    function showPosition(position) {
         pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            accuracy = position.coords.accuracy;
            accurOut.textContent = "Accuracy: " + accuracy.toFixed(1) + "m";
            // infoWindow.setPosition(pos);
            //infoWindow.setContent('Location found.');
            //infoWindow.open(map);
            if (isItFirstTime) {
                map.setCenter(pos);
                isItFirstTime = false;
            }
            marker.setPosition(pos);
    } 
    var counter = 0;
    var timerId = setInterval(function() {
                  var params = {
                                'latLng':pos
                                };
                                $.post('/geolocation/geolocation/writelocation',params, function(data){
                                   if (data.success === true){
                                       console.log(data.latLng);
//                                     btnSave.classList.add("display-none");
//                                     btnRemove.classList.remove("display-none");
                                   }
//                                   if (data.isGeotagSet === true){
//                                     alert("Already set!");
//                                   }
                            });  
                  counter += 1;
                  document.getElementById('textWatch').innerHTML = counter;
                  accurOut.textContent = "Accuracy: " +  accuracy.toFixed(1) + "m";
                  }, 30000);
   

var locateMeBtn = document.getElementById("btn-locate");
locateMeBtn.addEventListener("click",function(){
     map.setCenter(pos);
});







var markers2 = [];
var infoWindows = [];
var options = [];
var applyBtn = document.getElementById('apply');

$('.dropdown-menu a').on('click', function (event) {

    var $target = $(event.currentTarget),
            val = $target.attr('data-value'),
            $inp = $target.find('input'),
            idx;

    if ((idx = options.indexOf(val)) > -1) {
        options.splice(idx, 1);
        setTimeout(function () {
            $inp.prop('checked', false)
        }, 0);
    } else {
        options.push(val);
        setTimeout(function () {
            $inp.prop('checked', true)
        }, 0);
    }

    $(event.target).blur();
    applyBtn.classList.remove("display-none");
    return false;
});
var friendsCount = 0;

applyBtn.classList.add("display-none");

applyBtn.addEventListener("click", function () {
    var params = {
        'options': options
    };
    console.log(options);
   
    $.post('/geolocation/geolocation/fetch-friends', params, function (data) {
       applyBtn.classList.remove("display-none");
        if (data.success === true) {
            var friendsArr =  data.resultExtended;
            var table = document.getElementById('friendsTable');
            for (var i=0; i < friendsCount; i++){
                 table.deleteRow(-1);
            }
           
            var posit = [];
           
            console.log(markers2);
            if (typeof markers2 !== 'undefined' || (markers2 instanceof Array)) {
                                 for (var i = 0; i < markers2.length; i++) {
                                     markers2[i].setMap(null);
                                 } 
                                 markers2 = new Array();
                            }
           
           
            friendsArr.forEach(function (item, index, array) {
                if (item['1']){
                        var userPicture = '/uploads/resized/'+item['1'];
                    }else {
                        var userPicture = '/default/default.jpg';
                    }
                var userNickname = item['0'];
                var coordinates = JSON.parse(item['latLng']);
               // posit.push({lat:Number(coordinates.lat),lng:Number(coordinates.lng)});
               // 
                if (coordinates !== null) {
                              posit.push({lat:Number(coordinates.lat),lng:Number(coordinates.lng)});
                              var position = {lat:Number(coordinates.lat),lng:Number(coordinates.lng)};
                }else{
                    posit.push({lat:56.9683418,lng:12.01573409});
                     var position = {lat:56.9683418,lng:12.01573409};
                };
                var row = table.insertRow(-1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = "<a><img  src='"+userPicture+"' border=3 width='50' height='50'  /></a>";
                cell2.innerHTML = userNickname;
                cell3.innerHTML = Unix_timestamp(item['time']);
                cell4.innerHTML = "<button type='button' class='btn btn-primary btn-xs "+"dataindex"+index+"'>Find</button>";
                 
               friendsCount = index+1;
               
               
               marker = new google.maps.Marker({
                                    map:map,
                                    position:position
                                    });
                markers2.push(marker);
                var infoWindow = new google.maps.InfoWindow({
                                    content: userNickname
                                    });
                infoWindow.open(map, marker);    
                  
                var findBtn = document.querySelector("button.dataindex"+index);
                findBtn.addEventListener("click", function () {
                        map.setCenter(posit[index]);
                    });
                                   
            });
        }
     });
   map.setCenter(pos);  
});



function Unix_timestamp(t)
{
var dt = new Date(t*1000);
var year = dt.getFullYear();
var month = dt.getMonth();
var day = dt.getDay();
var hr = dt.getHours();
var m = "0" + dt.getMinutes();
var s = "0" + dt.getSeconds();
return  year+'/'+month+'/'+day+' '+ hr+ ':' + m.substr(-2) + ':' + s.substr(-2);  
}

 

}




