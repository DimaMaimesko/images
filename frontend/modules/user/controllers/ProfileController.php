<?php

namespace frontend\modules\user\controllers;
use yii\web\Controller;
use frontend\models\User;
use Yii;

/**
 * Description of ProfileController
 *
 * @author дз
 */
class ProfileController extends Controller {
    //put your code here
    public function actionView($nickname)
    {
        
//         $redis = Yii::$app->redis;
//         $result = $redis->executeCommand('set', ['test_collection', 'key1']);
//         echo  $redis->get('test_collection');die;
         
         $user = $this->findUser($nickname);
         return $this->render('view',[
            'user' => $user,
            
        ]);
    }
    /**
     * 
     * @param string $nickname
     * @return User
     * @throws \yii\web\NotFoundHttpException
     */
    public function findUser($nickname)
    {
        if($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()){
            return $user;
        } 
        throw new \yii\web\NotFoundHttpException();
    }
    
//    public function actionGenerate()
//    {
//        $faker = \Faker\Factory::create();
//        
//        for ($i = 0; $i < 10; $i++) {
//            $user = new User([
//                'username' => $faker->name,
//                'email' => $faker->email,
//                'about' => $faker->text(200),
//                'nickname' => $faker->regexify('[A-Za-z0-9_]{5,15}'),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//            $user->save(false);
//        }
//}
    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
        /* @var $currentUser = User */
        $currentUser = Yii::$app->user->identity;
        $targetUser = User::findUserById($id);

        $currentUser->followUser($targetUser);
       
        return $this->redirect(['/user/profile/view','nickname' => $targetUser->getNickname()]);
    }

    
    public function actionUnsubscribe($id)
    {   
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
        /* @var $currentUser = User */
        $currentUser = Yii::$app->user->identity;
        $targetUser = User::findUserById($id);

        $currentUser->unfollowUser($targetUser);
       
        return $this->redirect(['/user/profile/view','nickname' => $targetUser->getNickname()]);
    }
}
