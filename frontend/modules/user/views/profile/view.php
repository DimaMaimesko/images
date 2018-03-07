<?php
use yii\helpers\Html;
Use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
/* @var $user frontend\models\User */

?>
<h3><?php  echo Html::encode($user->username).' ('.Html::encode($user->nickname).')';?></h3>
<p><?php  echo HtmlPurifier::process($user->about);?></p><?php//благодяра HtmlPurifier мы можем разрешить пользователю воодить html код(например ссылки), при этом он будет экранирован ?>


<a href="<?= Url::to(['/user/profile/subscribe','id' => $user->getId()]); ?>" class="btn btn-success">Subscrube</a>
<a href="<?= Url::to(['/user/profile/unsubscribe','id' => $user->getId()]); ?>" class="btn btn-warning">Unsubscribe</a>

<h5>Subscriptions: </h5><?php  print_r($user->getSubscriptions()); ?>
<h5>Followers: </h5><?php  print_r($user->getFollowers()); ?>