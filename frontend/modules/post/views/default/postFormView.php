<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\PostFormModel */
/* @var $form ActiveForm */
$this->title = 'PostCreate';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
<div class="frontend-modules-post-views-default-postFormView">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'photo')->fileInput() ?>
        <?= $form->field($model, 'content')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- frontend-modules-post-views-default-postFormView -->
</div>
<div class="col-lg-2"></div>
