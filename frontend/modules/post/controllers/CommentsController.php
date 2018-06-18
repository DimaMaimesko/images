<?php

namespace frontend\modules\post\controllers;
use yii\web\Controller;
use frontend\modules\post\models\Comment;
use Yii;
use frontend\modules\post\models\Post;
use frontend\modules\geolocation\models\Geotags;

class CommentsController extends Controller {

    public function actionCommentFormView($postId) {
        if (Yii::$app->user->isGuest) {
                 Yii::$app->session->setFlash('info', 'You need login first!');
                 return $this->redirect(['/user/default/login']);
             }
              
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->post_id = $postId;
            $model->created_at = time();
            $model->status = 1;
            if ($model->validate() && $model->save ())  {
                // form inputs are valid, do something here
               $model->addComment($postId, Yii::$app->user->identity->id);
               Yii::$app->session->setFlash('success', 'Your comment is posted!');
               return $this->refresh();
            }
        }
        
//        $geotagsModel = new Geotags();
//        $geotag = $geotagsModel->find()->where(['post_id' => $postId])->one();
//        $lat = $geotag->lat;
//        $lng = $geotag->lng;
        
        return $this->render('commentFormView', [
                    'model' => $model,
                    'postId' => $postId,
//                    'lat' => $lat,
//                    'lng' => $lng,
        ]);
    }
    
    public function actionEdit($postId, $commentId) {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
        $model = new Comment();
        $model = Comment::findOne($commentId);
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->status = 1;
            if ($model->update(false)) {
                // form inputs are valid, do something here
                Yii::$app->session->setFlash('success', 'Your comment is updated!');
                return $this->render('commentFormView', [
                            'model' => $model,
                            'postId' => $postId,
                ]);
            }
        }
        return $this->render('commentEdit', [
                    'model' => $model,
                    'content' => $model->content,
        ]);
        //         Yii::$app->response->format =  \yii\web\Response::FORMAT_JSON;//теперь мы можем возвращать массив
//         $postId = Yii::$app->request->post('postId'); 
//         $commentId = Yii::$app->request->post('commentId'); 
//         
//         return [
//         'success' => true,
//         'postId' => $postId,
//         'commentId' => $commentId,
//          
//              ];
    }

    public function actionDelete($postId, $commentId) {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
        $model = new Comment();
        $model = Comment::findOne($commentId);
        if ($model && $model->delete()) {
            // form inputs are valid, do something here
            $model->delComment($postId, Yii::$app->user->identity->id);
            Yii::$app->session->setFlash('success', 'Your comment was deleted!');
            return $this->render('commentFormView', [
                        'model' => $model,
                        'postId' => $postId,
            ]);
        }

        return $this->goHome();
    }
    
    public function actionReport()
{
    if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     $postId = Yii::$app->request->post('postId'); 
     if(Post::makeReport($postId)){
        
         $numberOfReports = Post::countReports($postId);
         Post::updateReports($postId,$numberOfReports);
              return [
         'success' => true,
         'postId' => $postId,
         'numberOfReports' => $numberOfReports,
              ]; 
         
       
     }else{
          return [
         'success' => false,
         'postId' => $postId,
        
              ];
     }
         
   
}

}
