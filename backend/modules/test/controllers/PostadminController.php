<?php

namespace backend\modules\test\controllers;

use Yii;
use backend\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\post\models\Feed;

/**
 * PostadminController implements the CRUD actions for Post model.
 */
class PostadminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Post::findComplaints();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
            'defaultOrder' => [
            'user_id' => SORT_DESC,
            
        ]
    ],
        ]);
// возвращает массив Post объектов
//$posts = $dataProvider->getModels();
//echo "<pre>";print_r($posts);echo "</pre>";die;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Approve post in case it looks OK
     * @param type $id
     * @return type
     */
      public function actionApprove($id)
    {
       $post = $this->findModel($id);
       if ($post->approve())
       {
           Yii::$app->session->setFlash('success','Post marked as approved');
           return $this->redirect(['index']);
       }
    }
    
      public function actionDelete($id)
    {
        $post = $this->findModel($id);  
        if ($post->deletePost($id)){
             Yii::$app->session->setFlash('success','Post has been deleted');
             return $this->redirect(['index']);
        }  
       Yii::$app->session->setFlash('danger','ERROR!!!');
             return $this->redirect(['index']);
      
    }
}
