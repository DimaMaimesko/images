<?php

namespace frontend\modules\user\controllers;
use yii\web\Controller;
use frontend\models\User;
use Yii;
use yii\helpers\Html;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * Description of ProfileController
 *
 * @author дз
 */
class ProfileController extends Controller {
    //put your code here
    const REAL_SIZE = 0;
    const SMALL_SIZE = 1;
    
    
    public function actionView($nickname)
    {
//                    $model = new UploadForm;
//                    if (Yii::$app->request->isPost){
//                       
//                        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
//                        if ($model->upload()){
//                             $modelPicture = new PictureForm();
//                             $user = $this->findUser($nickname);
//                             $isFollower = $this->isFollower($user);
//                                return $this->render('view',[
//                                'user' => $user,
//                                'isFollower' => $isFollower,
//                                'modelPicture' => $modelPicture,
//                                'model' => $model,
//                                ]);  
//                        }
//                    }
       
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
    
    public function actionUploadPicture()   //AJAX
    {
        Yii::$app->response->format = Response::FORMAT_JSON;//теперь мы можем возвращать массив
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');//в свойство picture загружаем экземпляр класса UploadedFile 
        //теперь $model->picture содержит изображение которое мы загрузили
        if ($model->validate()){
            $user = Yii::$app->user->identity;
            
            $array = Yii::$app->storage->saveUploadedFile($model->picture,$user->id);//  id/ae/a7/8ea26ed7edb60db42d574eb5f4cd6c0deb78.jpg
            $user->picture = $array['fName']; 
            if ($user->save(false, ['picture'])){ // save(false, ['picture']) - валидацию проводить не требуется а так же сохраняем только атрибут picture 
                return [         //это будет выглядеть вот так: {"success":true,"pictureUri":"/uploads/33/95/6d94b3c303573e2e9677cedfab68fd5626c7.jpg"}
                     'success' => true,
                     'pictureUri' => Yii::$app->storage->getFile($user->picture),
                     'name' => $array['pName'],
                     'size' => $array['pSize'],
                 ];
            }
        }
       return ['success' => false, 'errors' => $model->getErrors()];
    }
    
    public function actionDeleteImage($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        /* @var $user User */
         $user = Yii::$app->user->identity;
         if ($user->deletePicture($user->id)){
             Yii::$app->session->setFlash('success', 'Picture deleted');
         }else{
             Yii::$app->session->setFlash('danger', 'Error occured');
         }
         return $this->redirect(['/user/profile/view','nickname' => $user->getNickname()]);
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
