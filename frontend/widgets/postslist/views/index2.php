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
<?php foreach ($postsList as $post): ?>
<div class="col-md-4 profile-post">
<a  href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $post['id']]); ?>">
<img src="/uploads/resized/<?php echo $post['photo']; ?>" id="post-picture"  class="author-image">
</a>
</div>
<?php endforeach; ?>
</div>
     
     
     


                                   

   




