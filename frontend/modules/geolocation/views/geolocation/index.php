<?php  
use frontend\assets\GeolocationAsset;
GeolocationAsset::register($this);
?>


<div class="geolocation-default-index">
    
</div>
<div class="row">
    <div class="col-md-8">  
        <h1>My Location</h1>

        <hr>
        <button id="btn-locate">Where am I?</button>
        <p id="accuracyOut"></p>

    </div>   
</div>       
<div class="row">
    <div class="col-md-8">

        <div id="map" style="width:100%;height:500px"></div>
        <div id="latit"></div>
        <div id="longit"></div>


        <p id="textWatch"></p>


    </div>

    <div class="col-md-4">
       
        <div class="table-responsive">
            <table id="friendsTable" class="table">
                <tr>
                    <th>Picture</th>
                    <th>Nickname</th>
                    <th>LastSeen</th> 
                    
                    
                </tr>
               
                
            </table>
        </div>
         <div class="button-group">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">MyFriends<span class="caret"></span></button>
            <ul class="dropdown-menu">
                <?php foreach ($friends as $numberOfFriend => $friend): ?>
                    <li><a href="#" class="small" data-value="<?= $friend['id'] ?>" tabIndex="-1"><input type="checkbox"/>&nbsp; <img src="<?php echo $friend['picture'] ? '/uploads/resized/' . $friend['picture'] : '/default/default.jpg'; ?>" width="50" height="50" class="author-image" style="margin-right: 1px" /><?= $friend['username'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            <button id="apply" type="button" class="btn btn-success">Apply</button>
        </div>
    </div>    
</div>




