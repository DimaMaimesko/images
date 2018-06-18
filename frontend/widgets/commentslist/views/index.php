 <?php
/* @var $postsList frontend\modules\post\models\Post; */

//use yii\helpers\Html;
//use yii\helpers\HtmlPurifier;
//use yii\helpers\Url;
use common\widgets\Alert;
use frontend\modules\post\models\Post;
use frontend\models\User;
use frontend\modules\post\models\Comment;
use yii\helpers\Url;
use frontend\modules\geolocation\models\Geotags;

?>
 <?php if ($currentPost['user_id'] === Yii::$app->user->id): ?>
 <a href="<?php echo Url::to(['/post/default/delete-post','postId' => $currentPost['id']]); ?>" type="button" class="close" aria-label="Close">
     <span aria-hidden="true"><strong>&times;</strong></span>
</a>
 <?php endif;  ?>
<hr>

<p style="font-size:75%" class="text-right"><em><?php if ($currentPost['created_at'])echo date('Y-m-d H:i',$currentPost['created_at']); ?></em></p>
<?php echo $currentPost['content']; ?>
<br>
<a  href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $currentPost['id']]);; ?>">
<img src="/uploads/resized/<?php echo $currentPost['photo']; ?>" id="profile-picture" style="max-width: 50%" class="center-block">
</a>
<hr>

<button type="button" class="btn btn-primary btn-xs btn-like <?php echo (('user-id:'.$currentUserId) && (Post::isLiked($currentPost['id'], $currentUserId)))? "display-none" : ""; ?>" data-id="<?php echo $currentPost['id']; ?>">
    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
    Like <span class="count-like badge"><?php echo Post::countLikes($currentPost['id']); ?></span></button>

<button type="button" class="btn btn-primary btn-xs btn-dislike <?php echo (('user-id:'.$currentUserId) && (Post::isLiked($currentPost['id'], $currentUserId)))? "" : "display-none"; ?>" data-id="<?php echo $currentPost['id']; ?>">
    <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
    Dislike <span class="count-dislike badge"><?php echo Post::countLikes($currentPost['id']); ?></span></button>
    
    <a class="btn btn-default btn-xs" href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $currentPost['id']]); ?>" role="button">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    Comments... <span class="count-like badge"><?php echo Comment::countComments($currentPost['id']); ?></span></a>
    
    <a id="for-geo" class="btn btn-default btn-xs btn-report <?php echo Post::isUserReported($currentPost['id']) ? ("display-none") : (""); ?>"  role="button"   post-id="<?php echo $currentPost['id']; ?>">
    <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
    Report complaint
    <i class="fa fa-cog fa-spin fa-fw icon-preloader" style="display:none"></i></a>
    
   <button id = "geo-modal"  type="button" data-toggle="modal" data-target="#geo-map" class="btn btn-primary btn-xs btn-geo" data-id="<?php echo $currentPost['id']; ?>">
    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
    Geo </button> 
   <div id="coordinates" data-lat="<?php echo Geotags::getLat($currentPost['id'])?>" data-lng="<?php echo Geotags::getLng($currentPost['id'])?>"></div> 
<!-- Modal -->
<div class="modal fade" id="geo-map" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Choose place</h4>
            </div>
            <div class="modal-body">

                <div id="map" style="width:100%;height:500px"></div>
                <div id="latit"></div>
                <div id="longit"></div>
                <button  class="<?php echo Geotags::isGeotagSet($currentPost['id']) ? ("display-none") : (""); ?>" id="btn-save">Save</button>
                <button  class="<?php echo Geotags::isGeotagSet($currentPost['id']) ? ("") : ("display-none"); ?>" id="btn-remove">Remove</button>
                
                <script>
                    function initMap(){
                         
                        var coordinates = document.getElementById("coordinates");
                        var isPreSet;
                        var start_lat = coordinates.getAttribute("data-lat");
                        if (start_lat === ""){
                            start_lat = 46.9683418;
                            isPreSet = false; 
                        }else{
                            start_lat = Number(start_lat);
                            isPreSet = true;
                        }
                        
                        var start_lng = coordinates.getAttribute("data-lng");
                        if (start_lng === ""){
                            start_lng = 32.01573409;
                        }else{
                           start_lng = Number(start_lng); 
                        }
                      
                        var options = {
                            zoom:8,
                            center:{lat:start_lat,lng:start_lng},
                            fullscreenControl:true,
                            zoomControl:true,
                            mapTypeId: google.maps.MapTypeId.SATELLITE,
                            disableDoubleClickZoom: true
                        };
                        var isMarkerChosen = false;
                        var map = new google.maps.Map(document.getElementById("map"),options);
                        
                        if (isPreSet){
                               var marker = new google.maps.Marker({
                                    map:map,
                                    position:{lat:start_lat,lng:start_lng}
                                    });
                        }
                        
                        var markers = [
//                            {
//                            coords:{lat:46.47747,lng:30.74262},
//                            iconImage:"/img/markers/MapMarker1.png",
//                            animation:google.maps.Animation.BOUNCE,
//                            info:"Helo!"
//                            },
                        ];
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
                            markers.push(marker);//засовываем маркер в массив маркеров
         
                        }
                        
                        var markerLat;   
                        var markerLng; 
                        
                        google.maps.event.addListener(map, "dblclick", function (event){
                            
                            if (!isMarkerChosen){
                               addMarker({
                               coords:event.latLng,
                               iconImage:"/img/markers/MapMarker1.png",
                               //info:"Lat:"+event.latLng.lat()+"<br>Lon:"+event.latLng.lng()
                               animation:google.maps.Animation.DROP
                               });
                               markerLat = event.latLng.lat();    
                               markerLng = event.latLng.lng();
                               isMarkerChosen = true;
                                console.log(isMarkerChosen);
                            }else {
                                alert("Already chosen!");
                            }
                            
                           
                        });
                        

                        
                        var btnSave = document.getElementById('btn-save');
                        var btnRemove = document.getElementById('btn-remove');
                        var latitField = document.getElementById('latit');
                        var longitField = document.getElementById('longit');
                        
                        btnSave.addEventListener("click",saveMarker);
                        btnRemove.addEventListener("click",removeMarker);
                        var isSaved = false;
                        function saveMarker(){
                            if (isMarkerChosen && !isSaved){
                               isSaved = true;
                                console.log(isMarkerChosen);
                               latitField.innerHTML = markerLat;
                               longitField.innerHTML = markerLng; 
                            
                            
                            var postId = document.getElementById("for-geo");
                            var params = {
                                'postId': postId.getAttribute("post-id"),
                                'markerLat':markerLat,
                                'markerLng':markerLng
                                };
                                $.post('/geolocation/default/writegeotag',params, function(data){
                                   if (data.success === true){
                                     console.log("Added");
                                     btnSave.classList.add("display-none");
                                     btnRemove.classList.remove("display-none");
                                   }
                                   if (data.isGeotagSet === true){
                                     alert("Already set!");
                                   }
                            });
                            }
                        }
                        function removeMarker(){
                            latitField.innerHTML = "";
                            longitField.innerHTML = "";
                            for (var i = 0; i < markers.length; i++) {
                               markers[i].setMap(null);
                            }
                            if (typeof marker !== 'undefined') {
                                // the variable is defined
                             marker.setMap(null);    
                            }
                           
                            markers = [];
                            btnSave.classList.remove("display-none");
                            btnRemove.classList.add("display-none");
                            isMarkerChosen = false;
                            isSaved = false;
                            var postId = document.getElementById("for-geo");
                            var params = {
                                'postId': postId.getAttribute("post-id")
                                };
                                $.post('/geolocation/default/removegeotag',params, function(data){
                                   if (data.success === true){
                                     console.log("Removed");
                                   }
                                });
                            }
                       
                       
                       var arr = [ 1, 2, 3, 46.9683418, 32.01573409 ];

var serializedArr = JSON.stringify( arr );
// "[1, 2, 3]"

var unpackArr = JSON.parse( serializedArr );
                   alert(unpackArr);     
                   alert(serializedArr);     
                    }
                   // If your backend is written in PHP,
                   //  there are similar methods to work with JSON strings
                   //   there: json_encode() (PHP docu) and json_decode() (PHP docu).
   

                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSC2Eca-gleFwSuaLBMMLePnCXoOxoHoo&callback=initMap"></script>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<?php foreach ($comments as $comment):  ?>
     <hr> 
     <?php echo User::findUserNameBy($comment['user_id']);  ?>
     <?php echo " (".date('Y-m-d H:i',$comment['created_at']).")"; ?>
     <br>
     <?php if ($currentUserId === $comment['user_id']): ?>
        <a type="button" class="btn btn-default btn-xs" 
           href="<?php echo Url::to(['/post/comments/edit','postId' => $currentPost['id'],'commentId' => $comment['id']]); ?>"
            <span style="visibility:hidden" class="glyphicon glyphicon-refresh spinning"></span>
            Edit
         </a>
     <?php endif;  ?>
     <?php if ($currentUserId === $currentPost['user_id']): ?>
        <a type="button" class="btn btn-default btn-xs" 
           href="<?php echo Url::to(['/post/comments/delete','postId' => $currentPost['id'],'commentId' => $comment['id']]); ?>"
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            Delete
         </a>
     <?php endif;  ?>
     <p>
        <?php   echo $comment['content']; ?>
     </p>
<?php endforeach;  ?>
 

  
       



