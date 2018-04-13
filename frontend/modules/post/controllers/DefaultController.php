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
   
    
    public function actionCreate() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        $model = new PostFormModel(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {

            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->save()) {//так же выполнится событие EVENT_AFTER_VALIDATE 
                return $this->redirect(['/user/profile/view','nickname' =>Yii::$app->user->id]);
            } 
        }
        
        return $this->render('PostFormView', [
                    'model' => $model,
        ]);
    }

    public function actionLike()
{
     if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     $postId = Yii::$app->request->post('id'); //это id поста который мы лайкаем
     $currentUserId = Yii::$app->user->id;
     if (Post::setLikeToPost($postId,$currentUserId))
     { 
         $usersWhoLikes = Post::getLikes($postId);
         return [
         'success' => true,
         'id' => $postId,
         'usersWhoLikes' => $usersWhoLikes,
         'countLikes' => Post::countLikes($postId),   
              ];
     }
     else {
         return [
         'success' => false,
         'id' => $postId,
              ];
         }
}
public function actionDisLike()
{
     if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     $postId = Yii::$app->request->post('id'); //это id поста который мы лайкаем
     $currentUserId = Yii::$app->user->id;
     if (Post::delLikeToPost($postId,$currentUserId))
     {
         $usersWhoLikes = Post::getLikes($postId);
         return [
         'success' => true,
         'id' => $postId,
         'usersWhoLikes' => $usersWhoLikes,
         'countLikes' => Post::countLikes($postId),   
              ];
     }
     else {
         return [
         'success' => false,
         'id' => $postId,
              ];
         }
}


}
