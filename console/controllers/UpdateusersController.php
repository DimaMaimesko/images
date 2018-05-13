<?php
namespace console\controllers;
use yii\console\Controller; 
use Yii;
/**
 * Description of UpdateusersController
 *
 * @author дз
 */
class UpdateusersController extends Controller{
    //put your code here
    public function actionUpdate()
    {
        Yii::$app->onLineUsers->updateUsersonlineHash('usersonline'); 
        
        //echo "Hello from Update!"; 
    }
}

