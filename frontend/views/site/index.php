<?php
use yii\helpers\Url;
use frontend\modules\post\models\Post;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\modules\post\models\Comment;
use Yii;
/* @var $this yii\web\View */
/* @var $users[] frontend\models\User */
/* @var $currentUser frontend\models\User */
/* @var $myFeeds frontend\modules\post\models\User */

$this->title = 'My Yii Application';
?>

   
   <div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-2">
                <h4>Explore users (<?= count($users); ?>)</h4>
                <span class="bg-info">Active visitors: <strong><?php echo Yii::$app->onLineUsers->countGuests();?></strong></span>

                 <?php foreach ($users as $user): ?>
                    <div class="post-meta"> 
                        <div class="post-title">
                            <img src="<?php echo $user->picture ? '/uploads/resized/' . $user->picture : '/default/default.jpg'; ?>" width="50" height="50" class="author-image" style="margin-right: 1px" />
                        
                       <div class="author-name">
                            <a class="<?= (Yii::$app->user->id == $user->id) ? 'bg-success' : ''; ?>"
                               href="<?= Url::to(['user/profile/view', 'nickname' => $user->getNickname()]); ?>"><?= $user->username; ?>
                            </a>
                           <?php if(Yii::$app->onLineUsers->isUserOnline($user->id)): ?>
                           <span class="bg-success">Online</span>
                            <?php else: ?>
                            <span class="bg-danger">Offline</span>
                           <?php endif; ?>
                        </div>
                        </div>
                    </div>
                <hr style="margin-top: 1px; margin-bottom: 3px">

                <?php endforeach; ?>
               

                <p><a class="btn btn-default center-block" href="<?= Url::to(['site/add-users']); ?>">show more... &raquo;</a></p>
            </div>
            <div class="col-lg-8">
                
                                  
                       
                               
      
                <h2>My feed (<?= count($myFeeds); ?>)</h2>
                              
                <?php if ($myFeeds): ?>
                    <?php foreach ($myFeeds as $oneFeed): ?>
                        <hr> 
                                              
                        
                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($oneFeed['author_nickname']) ? $oneFeed['author_nickname'] : $oneFeed['author_id']]); ?>">
                                    <div class="col-md-12 bg-warning">
                                        <img src="<?php echo $oneFeed['author_picture']; ?>" width="40" height="40" class="img-circle" />
                                        <div class="author-name">

                                            <?php echo Html::encode($oneFeed['author_nickname']); ?>

                                        </div >   
                                        <?php echo " (" . Html::encode($oneFeed['author_name']) . ")"; ?>
                                    </div>
                        </a>
                               
                        <hr>
                        <p style="font-size:75%" class="text-right"><em><?php if ($oneFeed['post_created_at']) echo date('Y-m-d H:i', $oneFeed['post_created_at']); ?></em></p>
                        <?php echo $oneFeed['post_description']; ?>
                        <br>
                        <a href="<?php echo Url::to(['/post/comments/comment-form-view', 'postId' => $oneFeed['post_id']]); ?>">
                            <img src="/uploads/resized/<?php echo $oneFeed['post_filename']; ?>" id="profile-picture" style="max-width: 50%" class="center-block">
                        </a>
                        <hr>

                        <button type="button" class="btn btn-primary btn-xs btn-like <?php echo (('user-id:' . $currentUser->id) && (Post::isLiked($oneFeed['post_id'], $currentUser->id))) ? "display-none" : ""; ?>" data-id="<?php echo $oneFeed['post_id']; ?>">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                            Like <span class="count-like badge"><?php echo Post::countLikes($oneFeed['post_id']); ?></span></button>

                        <button type="button" class="btn btn-primary btn-xs btn-dislike <?php echo (('user-id:' . $currentUser->id) && (Post::isLiked($oneFeed['post_id'], $currentUser->id))) ? "" : "display-none"; ?>" data-id="<?php echo $oneFeed['post_id']; ?>">
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                            Dislike <span class="count-dislike badge"><?php echo Post::countLikes($oneFeed['post_id']); ?></span></button>

                        <a class="btn btn-default btn-xs" href="<?php echo Url::to(['/post/comments/comment-form-view', 'postId' => $oneFeed['post_id']]); ?>" role="button">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Comments...<span class="count-dislike badge"><?php echo Comment::countComments($oneFeed['post_id']); ?></span></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>
                    
                <?php endif; ?>
               <p><a class="btn btn-default center-block" href="<?= Url::to(['site/add-feeds']); ?>">show more... &raquo;</a></p>
            </div>
            <div class="col-lg-8">
               
            </div>
        </div>

    </div>
</div>

