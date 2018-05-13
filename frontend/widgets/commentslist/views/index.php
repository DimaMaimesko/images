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
    
    <a class="btn btn-default btn-xs btn-report <?php echo Post::isUserReported($currentPost['id']) ? ("display-none") : (""); ?>"  role="button"   post-id="<?php echo $currentPost['id']; ?>">
    <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
    Report abuse
    <i class="fa fa-cog fa-spin fa-fw icon-preloader" style="display:none"></i></a>
    
 
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
 

  
       




