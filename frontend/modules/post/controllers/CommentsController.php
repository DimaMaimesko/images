<?php

namespace frontend\modules\post\controllers;
use yii\web\Controller;
use frontend\modules\post\models\Comment;
use Yii;
 

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
        return $this->render('commentFormView', [
                    'model' => $model,
                    'postId' => $postId,
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

}
