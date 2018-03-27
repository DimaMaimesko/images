<?php
/* @var $user frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm; */
/* @var $model frontend\models\UploadForm */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use dosamigos\fileupload\FileUpload;
use frontend\widgets\postslist\Postslist;
?>
<div class="row">
    <div class="col-md-3">
        <h3>Your posts:</h3>
        <div style="border: 3px dotted greenyellow; padding: 5px; margin: 5px;">
            <?php echo Postslist::widget(['id' => $user->id]);//$user->id - это id пользователя профайл которого мы сейчас просматриваем  ?>  
        </div>
    </div>
    <div class="col-md-6">
        
        <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" style="max-width: 90%" class="img-circle center-block">
        <h5 id="name"></h5>
        <h5 id="size"></h5>
        <div id="profile-image"></div>
               
        <hr>
        <?php if (Yii::$app->user->id ==$user->id): //Yii::$app->user->id - это id пользователя профайл который сейчас залогинен?>
            <?=
            FileUpload::widget([
                'model' => $modelPicture,
                'attribute' => 'picture',
                'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                'options' => ['accept' => 'image/*'],
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                console.log(data.result.success);
                                if(data.result.success){
                                    $("#w2-success-0").hide(); // прячем flash-сообщение Picture deleted в случае если загрузка изображения  произошла срвзу после удаления 
                                    $("#profile-image").text("Profile image updated").attr("class","alert alert-success alert-dismissible").show();
                                    $("#profile-picture").attr("src",data.result.pictureUri);
                                    $("#name").text(data.result.name);
                                    $("#size").text(data.result.size);
                                } else{
                                    $("#profile-image").html(data.result.errors.picture).attr("class","alert alert-danger alert-dismissible").show();
                                                                   }
                            }',
                ],
            ]);
            ?>
         <a href="<?= Url::to(['/user/profile/delete-image', 'id' => $user->getId()]); ?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> Delete file...</a>
         <?php endif; ?>
          
        
        <h3 class="text-center"><?php echo Html::encode($user->username) . ' (' . Html::encode($user->nickname) . ')'; ?></h3>
        <p><?php echo HtmlPurifier::process($user->about); ?></p><?php //благодяра HtmlPurifier мы можем разрешить пользователю воодить html код(например ссылки), при этом он будет экранирован  ?>

        <?php if (($user->id) != Yii::$app->user->id): ?>
            <?php if (!$isFollower): ?>
                <a href="<?= Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-success">Subscrube</a>
            <?php endif; ?>
            <?php if ($isFollower): ?>    
                <a href="<?= Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-warning">Unsubscribe</a>
            <?php endif; ?>
           
        <?php endif; ?>
        <hr>
        <!-- Small modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Following (<?= $user->getNumberOfSubscriptions(); ?>)</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Following</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($user->getSubscriptions() as $subscriber): ?>
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($subscriber['nickname']) ? $subscriber['nickname'] : $subscriber['id']]); ?>">
                                <?= Html::encode($subscriber['username']); ?>
                            </a>
                            <hr>  
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Small modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Followers (<?= $user->getNumberOfFollowers(); ?>)</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Followers</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($user->getFollowers() as $follower): ?>
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                                <?= Html::encode($follower['username']); ?>
                            </a>
                            <hr>  
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Small modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Friends (<?= $user->getNumberOfFriends(); ?>)</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Friends</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($user->getFriends() as $friend): ?>
                            <a href="<?= Url::to(['/user/profile/view', 'nickname' => ($friend['nickname']) ? $friend['nickname'] : $friend['id']]); ?>">
                                <?= Html::encode($friend['username']); ?>
                            </a>
                            <hr>  
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
    <?php if (Yii::$app->user->id ==$user->id): ?>
        <a href="<?= Url::to(['/post/default/create', 'id' => $user->getId()]); ?>" class="btn btn-warning center-block">Create post...</a>   
    <?php endif; ?>
    </div>
    <div class="col-md-3"></div>
</div>

