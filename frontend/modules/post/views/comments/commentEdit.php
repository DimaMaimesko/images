<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\Comment */
/* @var $form ActiveForm */

?>


    <?php $form = ActiveForm::begin(); ?>

      
       
       <?= Html::activeTextarea($model, 'content',['value' => $content,'cols'=>'100', 'rows'=>'5']) ?>
    
        <div class="form-group">
           
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- frontend-modules-post-views-commentFormView -->

  