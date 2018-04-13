<?php
namespace frontend\tests\fixtures;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture {
    //put your code here
    public $modelClass = 'frontend\models\User';
    public $depends = [
        'frontend\tests\fixtures\PostFixture',
    ];
    
}
