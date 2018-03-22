<?php

namespace frontend\modules\post\controllers;
use Yii;
use yii\web\Controller;
use frontend\modules\post\models\PostFormModel;
use yii\web\UploadedFile;
use frontend\modules\post\models\Post;
/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
   
    
    public function actionCreate()
{
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $model = new PostFormModel();
   
        if ($model->load(Yii::$app->request->post())) {
        
        $model->photo = UploadedFile::getInstance($model, 'photo');
        if ($model->validate()) {
            // form inputs are valid, do something here
             $user = Yii::$app->user->identity;
             $post = new Post();
             $array = Yii::$app->storage->saveUploadedFile($model->photo,$user->id);//  id/ae/a7/8ea26ed7edb60db42d574eb5f4cd6c0deb78.jpg
            $post->photo = $array['fName']; 
            $post->content = $model->content;
            $post->user_id = $user->id;
            if ($post->save(false)){ // save(false, ['picture']) - валидацию проводить не требуется а так же сохраняем только атрибут picture 
               Yii::$app->session->setFlash('success', 'Photo posted');
            }else{
               Yii::$app->session->setFlash('danger', 'Error occured while posting');
            } 
            
             return $this->redirect(['/user/profile/view','nickname' => $user->getNickname()]);
        }
    }

    return $this->render('PostFormView', [
        'model' => $model,
    ]);
}
}
