<?php
/* @var $postsList frontend\modules\post\models\Post; */
//use yii\helpers\Html;
//use yii\helpers\HtmlPurifier;
//use yii\helpers\Url;
use common\widgets\Alert;?>
<?= Alert::widget() ?>

<?php foreach ($postsList as $post): ?>
<hr>
<?php echo $post['content']; ?>

<br>

<img src="/uploads/resized/<?php echo $post['photo']; ?>" id="profile-picture" style="max-width: 50%" class="center-block">
<hr>
<?php endforeach; ?>
    






