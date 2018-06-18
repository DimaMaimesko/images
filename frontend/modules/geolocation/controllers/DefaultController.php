<?php

namespace frontend\modules\geolocation\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use frontend\modules\geolocation\models\Geotags;
/**
 * Default controller for the `geolocation` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTravercy()
    {
        return $this->render('travercy');
    }
    
    public function actionWritegeotag()
    {
         Yii::$app->response->format = Response::FORMAT_JSON; //теперь мы можем возвращать массив
         $geotagsModel = new Geotags();
         if (Yii::$app->request->isPost) {
           $postId = Yii::$app->request->post('postId');
           $lat = Yii::$app->request->post('markerLat');
           $lnt = Yii::$app->request->post('markerLng');
           if (!Geotags::isGeotagSet($postId)){
               $geotagsModel->post_id = $postId;
               $geotagsModel->lat = $lat;
               $geotagsModel->lng = $lnt;
               $geotagsModel->created_at = time();
               $geotagsModel->status = 1;
               if ($geotagsModel->validate() && $geotagsModel->save ())  {
                 return ['success' => true,
                       'postId' => $postId,
                       'isGeotagSet' => false,
                       ];
                }else{
                   return ['success' => false,
                           'isGeotagSet' => false,
                         ];
               }  
           }else{
               return ['success' => false,
                       'isGeotagSet' => true,
                      ];
           }
          
        }
    }
    public function actionRemovegeotag()
    {
         Yii::$app->response->format = Response::FORMAT_JSON; //теперь мы можем возвращать массив
         $geotagsModel = new Geotags();
         if (Yii::$app->request->isPost) {
           $postId = Yii::$app->request->post('postId');
           $geotag = $geotagsModel->find()->where(['post_id' => $postId])->one();
           if (isset($geotag)){
             if ($geotag->delete())  {
              return ['success' => true,
                     ];
            }else{
                return ['success' => false,
                       ];
           }   
           }
           
        }
    }

}
