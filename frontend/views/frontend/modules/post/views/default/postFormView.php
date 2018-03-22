<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\PostFormModel */
/* @var $form ActiveForm */
?>
<div class="frontend-modules-post-views-default-postFormView">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'picture') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- frontend-modules-post-views-default-postFormView -->
