<?php

namespace frontend\modules\user\controllers;
use yii\web\Controller;
use frontend\models\User;
/**
 * Description of ProfileController
 *
 * @author дз
 */
class ProfileController extends Controller {
    //put your code here
    public function actionView($id)
    {
        $user = User::findOne($id);
        return $this->render('view',[
            'user' => $user,
        ]);
    }
}
