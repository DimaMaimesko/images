<?php

namespace frontend\modules\geolocation\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use app\modules\geolocation\models\Geolocation;
use frontend\models\User;
/**
 * Default controller for the `geolocation` module
 */
class GeolocationController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = new User();
        $user = $user->findUserById(Yii::$app->user->id);
        $friends = $user->getFriends();
       
        return $this->render('index',[
            'friends' => $friends
        ]);
    }
    
  public function actionWritelocation()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
         Yii::$app->response->format = Response::FORMAT_JSON; //теперь мы можем возвращать массив
         $geolocationModel = new Geolocation;
         $currentUser = Yii::$app->user->id;
         if (Yii::$app->request->isPost) {
           $latLng = Yii::$app->request->post('latLng');
           $latLngJson = json_encode($latLng);
           if($geolocationModel->writeOrNot($currentUser,$latLngJson)){
                 return ['success' => true,
                        ];
           }else{
                 return ['success' => false,
                        ];
               }  
        }
    }   
  public function actionFetchFriends()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('info', 'You need login first!');
            return $this->redirect(['/user/default/login']);
        }
         Yii::$app->response->format = Response::FORMAT_JSON; //теперь мы можем возвращать массив
         $geolocationModel = new Geolocation;
         //$currentUser = Yii::$app->user->id;
         if (Yii::$app->request->isPost) {
           $friendsIds = Yii::$app->request->post('options');
           $result = $geolocationModel->fetchFriendsParams($friendsIds);
           $resultExtended = $geolocationModel->addParamsFromUser($result);
           return ['success' => true,
                    'resultExtended' => $resultExtended,
                  ];
           
        }
    }   
}      
           
           
          
         
//           if (!Geotags::isGeotagSet($postId)){
//               $geotagsModel->post_id = $postId;
//               $geotagsModel->lat = $lat;
//               $geotagsModel->lng = $lnt;
//               $geotagsModel->created_at = time();
//               $geotagsModel->status = 1;
//               if ($geotagsModel->validate() && $geotagsModel->save ())  {
//                 return ['success' => true,
//                       'postId' => $postId,
//                       'isGeotagSet' => false,
//                       ];
//                }else{
//                   return ['success' => false,
//                           'isGeotagSet' => false,
//                         ];
//               }  
//           }else{
//               return ['success' => false,
//                       'isGeotagSet' => true,
//                      ];
//           }
          
       
    

