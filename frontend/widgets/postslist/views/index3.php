<?php
/* @var $postsList frontend\modules\post\models\Post; */


//use yii\helpers\Html;
//use yii\helpers\HtmlPurifier;
//use yii\helpers\Url;
use common\widgets\Alert;
use frontend\modules\post\models\Post;
use yii\helpers\Url;
use frontend\modules\post\models\Comment;
?>
<?= Alert::widget() ?>
 <div class="row profile-posts">
     <div id='allposts'>
<?php foreach ($postsList as $post): ?>
<div id="posts" class="col-md-4 profile-post">
<a  href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $post['id']]); ?>">
<img src="/uploads/resized/<?php echo $post['photo']; ?>" id="post-picture"  class="author-image">
</a>
</div>
         <div id="last1"></div>
<?php endforeach; ?>
         </div>
     
   
</div>
 <p> <button id="loadPosts" target-user-id="<?= $targetUserId  ?>" class="btn btn-info center-block">Show more...<span id="leftPosts"></span><span id="left"></span></button> </p>
    


                                   

   





