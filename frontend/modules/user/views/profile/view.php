<?php
/* @var $user frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm; */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
//use Yii;
use dosamigos\fileupload\FileUpload;

?>
<div class="row">
    <div class="col-md-4"></div>
  <div class="col-md-4">
<img src="<?php echo $user->getPicture(); ?>" style="max-width: 90%" alt="..." class="img-circle">
<h3><?php  echo Html::encode($user->username).' ('.Html::encode($user->nickname).')';?></h3>
<p><?php  echo HtmlPurifier::process($user->about);?></p><?php//благодяра HtmlPurifier мы можем разрешить пользователю воодить html код(например ссылки), при этом он будет экранирован ?>

<?php if(($user->id) != Yii::$app->user->id): ?>
    <?php if(!$isFollower): ?>
        <a href="<?= Url::to(['/user/profile/subscribe','id' => $user->getId()]); ?>" class="btn btn-success">Subscrube</a>
    <?php endif; ?>
    <?php if($isFollower): ?>    
        <a href="<?= Url::to(['/user/profile/unsubscribe','id' => $user->getId()]); ?>" class="btn btn-warning">Unsubscribe</a>
    <?php endif; ?>
<?php endif; ?>
<hr>       

        
<!-- Small modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Following (<?= $user->getNumberOfSubscriptions();  ?>)</button>
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
        <a href="<?= Url::to(['/user/profile/view','nickname' => ($subscriber['nickname']) ? $subscriber['nickname'] : $subscriber['id']]); ?>">
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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Followers (<?= $user->getNumberOfFollowers();  ?>)</button>
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
        <a href="<?= Url::to(['/user/profile/view','nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Friends (<?= $user->getNumberOfFriends();  ?>)</button>
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
        <a href="<?= Url::to(['/user/profile/view','nickname' => ($friend['nickname']) ? $friend['nickname'] : $friend['id']]); ?>">
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

<hr>

<?= FileUpload::widget([
    'model' => $modelPicture,
    'attribute' => 'picture',
    'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*'],
    'clientOptions' => [
        'maxFileSize' => 8000000
    ],
    // Also, you can specify jQuery-File-Upload events
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
    ],
]); ?>
</div>
 <div class="col-md-4"></div>
</div>
    