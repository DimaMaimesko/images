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

<?php foreach ($postsList as $post): ?>
<hr>
<p style="font-size:75%" class="text-right"><em><?php if ($post['created_at'])echo date('Y-m-d H:i',$post['created_at']); ?></em></p>
<?php echo $post['content']; ?>
<br>
<a  href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $post['id']]); ?>">
<img src="/uploads/resized/<?php echo $post['photo']; ?>" id="post-picture" style="max-width: 50%" class="center-block">
</a>
<hr>

<button type="button" class="btn btn-primary btn-xs btn-like <?php echo (('user-id:'.$currentUserId) && (Post::isLiked($post['id'], $currentUserId)))? "display-none" : ""; ?>" data-id="<?php echo $post['id']; ?>">
    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
    Like <span class="count-like badge"><?php echo Post::countLikes($post['id']); ?></span></button>

<button type="button" class="btn btn-primary btn-xs btn-dislike <?php echo (('user-id:'.$currentUserId) && (Post::isLiked($post['id'], $currentUserId)))? "" : "display-none"; ?>" data-id="<?php echo $post['id']; ?>">
    <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
    Dislike <span class="count-dislike badge"><?php echo Post::countLikes($post['id']); ?></span></button>
    
    <a class="btn btn-default btn-xs" href="<?php echo Url::to(['/post/comments/comment-form-view','postId' => $post['id']]); ?>" role="button">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
     Comments...<span class="count-dislike badge"><?php echo Comment::countComments($post['id']); ?></span></a>
<?php endforeach; ?>
 

   




