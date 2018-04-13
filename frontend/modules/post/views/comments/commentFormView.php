<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use frontend\widgets\postslist\Postslist;
use frontend\widgets\commentslist\Commentslist;
/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\Comment */
/* @var $form ActiveForm */

?>


    <?php $form = ActiveForm::begin(); ?>

      
        <?= $form->field($model, 'content') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<div style="border: 3px dotted greenyellow; padding: 5px; margin: 5px;">
            <?php echo Commentslist::widget(['post_id' => $postId,]);//$user->id - это id пользователя профайл которого мы сейчас просматриваем  ?>  
        </div>
<div class="frontend-modules-post-views-commentFormView">
</div><!-- frontend-modules-post-views-commentFormView -->

  