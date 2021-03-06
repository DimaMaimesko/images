<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'id',
              'format' => 'raw',
              'label' => 'Post Id',
              'value' => function($post){
                    /*@var $post \backend\models\Post */
                     return Html::a($post->id,['view','id' => $post->id]);  
              },
            ],
            'user_id',
            'caption',
            'content:ntext',
            [
              'attribute' => 'photo',
              'format' => 'raw',
              'label' => 'Photo',
              'value' => function($post){
                    /*@var $post \backend\models\Post */
                     return Html::img($post->getImage(),['width' => '130px']);  
              },
            ],
            'created_at:datetime',
            //'status',
            'report',
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;&nbsp;{approve}&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'approve' => function ($url,$post){
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>',['approve','id'=>$post->id]);//ссылка ведет нас на экшин approve текущего контроллера идентификатором текущего поста
                    }
                ],
                
            ],
        ],
    ]); ?>
</div>
<div id="test"></div>
<div id="test2"></div>
<?php $this->registerJsFile('/js/scripts.js', ['depends'=>[
 backend\assets\AppAsset::className()
]]);  ?>

