<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\post\models\Post */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'caption',
            'content:ntext',
            [
              'attribute' => 'photo',
              'format' => 'raw',
              'label' => 'Photo',
              'value' => function($post){
                    /*@var $post \backend\models\Post */
                     return Html::img($post->getImage(),['width' => '400px']);  
              },
            ],
            'created_at:datetime',
            'status',
            'report',
        ],
    ]) ?>

</div>

