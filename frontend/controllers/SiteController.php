<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
//use frontend\modules\post\models\Feed;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $limit = Yii::$app->params['feedPostLimit'];
        if (!Yii::$app->user->isGuest){
            /* @var $currentUser User */
            $currentUser = Yii::$app->user->identity;
            $myFeeds = $currentUser->getMyFeed($limit);
                     
        }else{
            $myFeeds = NULL;
            $currentUser = NULL;
        }
        
       
        $users = User::find()->all();
        return $this->render('index',[
            'users' => $users,
            'myFeeds' => $myFeeds,
            'limit' => $limit,
            'currentUser' => $currentUser,
        ]);
    }
   
}
