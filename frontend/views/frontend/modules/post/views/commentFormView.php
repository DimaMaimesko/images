<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\Comment */
/* @var $form ActiveForm */
?>
<div class="frontend-modules-post-views-commentFormView">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'post_id') ?>
        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'content') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- frontend-modules-post-views-commentFormView -->
