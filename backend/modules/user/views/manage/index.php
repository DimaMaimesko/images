<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'id',
              'format' => 'raw',
              'label' => 'UserId',
              'value' => function($user){
                    /*@var $post \backend\models\User */
                     return Html::a($user->id,['view','id' => $user->id]);  
              },
            ],
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'status',
            'created_at:datetime',
            //'updated_at:datetime',
            //'about:ntext',
            //'type',
            'nickname',
            [
              'attribute' => 'picture',
              'format' => 'raw',
              'label' => 'Picture',
              'value' => function($user){
                    /*@var $post \backend\models\User */
                     return Html::img($user->getImage(),['width' => '130px']);  
              },
            ],
            [
              'attribute' => 'roles',
              'value' => function($user){
                    /*@var $user \backend\models\User */
                     return implode(',',$user->getRoles());  
              },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
