<?php

namespace frontend\modules\user\controllers;
use yii\web\Controller;
use frontend\models\User;
use Yii;
use yii\helpers\Html;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
/**
 * Description of ProfileController
 *
 * @author дз
 */
class ProfileController extends Controller {
    //put your code here
    public function actionView($nickname)
    {
         $modelPicture = new PictureForm();
         $user = $this->findUser($nickname);
         $isFollower = $this->isFollower($user);
         return $this->render('view',[
            'user' => $user,
            'isFollower' => $isFollower,
            'modelPicture' => $modelPicture,
        ]);
    }
    /**
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
    public function isFollower($user)
    {
        $currentUserId = Yii::$app->user->id;
        $targetUserId = $user->id;
        $redis = Yii::$app->redis;
        $arrayOfFollowers = $redis->executeCommand('smembers', ['user:'.$targetUserId.':followers']);
        foreach ($arrayOfFollowers as $follower) {
            if($currentUserId == $follower)
                return true;
        }
        return false;
    }
    

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
        Yii::$app->session->setFlash('success', 'You are following<b>  '.Html::encode($targetUser->username).' </b>now!');
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
         Yii::$app->session->setFlash('warning', 'You are not following<b> '.Html::encode($targetUser->username).' </b>now!');
        return $this->redirect(['/user/profile/view','nickname' => $targetUser->getNickname()]);
    }
    
    public function actionUploadPicture()
    {
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');//в свойство picture загружаем экземпляр класса UploadedFile 
        //теперь $model->picture содержит изображение которое мы загрузили
        if ($model->validate()){
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);
            if ($user->save(false, ['picture'])){ // save(false, ['picture']) - вылидацию проводить не требуется а так же сохраняем только атрибут picture 
                 print_r($user->attributes);
            }
           
           
        }
        
        echo '<pre>';print_r($model->getErrors());echo '</pre>';
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
}
