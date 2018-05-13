<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\Cookie;
use GeoIp2\Database\Reader;
use yii\base\ErrorException;
//use yii\web\Session;
//use frontend\modules\post\models\Feed;

/**
 * Site controller
 */
class SiteController extends Controller
{
    
   
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

//    public function behaviors()
//{
//    return [
//        [
//            'class' => 'yii\filters\PageCache',
//            'only' => ['index'],
//            'duration' => 30,
//            'variations' => [
//                \Yii::$app->language,
//            ],
////            'dependency' => [
////                'class' => 'yii\caching\DbDependency',
////                'sql' => 'SELECT COUNT(*) FROM post',
////            ],
//        ],
//    ];
//}
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
//        $readerCountry = new Reader('geo/GeoLite2-Country.mmdb');
//        $geo = $readerCountry->country($ip);
//        var_dump($geo->country->isoCode); //UA
//        var_dump($geo->country->names); //Ukraine
//        $readerCountry = new Reader('geo/GeoLite2-City.mmdb');
//        $geo = $readerCity->city($ip);
//        var_dump($geo->city->name); //Zhytomyr
  
        //$limit = Yii::$app->params['feedPostLimit'];
        if (!Yii::$app->user->isGuest){
            /* @var $currentUser User */
            $currentUser = Yii::$app->user->identity;
            
            // $myFeeds = Yii::$app->cache->get('cached_myFeeds');
           // if ($myFeeds === false) {
               // $myFeeds = $currentUser->getMyFeed($limit);
               // Yii::$app->cache->set('cached_myFeeds',$myFeeds , 30);
            //}
           
            
             $session = Yii::$app->session;
        $session->open();
        if ($session->has('stateFeeds')){
             $stateFeeds = $session->get('stateFeeds');
             $limitFeeds = $stateFeeds;
         }else{
             $session->set('stateFeeds', Yii::$app->params['feedsToShow']);
             $limitFeeds = $session->get('stateFeeds');
         }
                $myFeeds = $currentUser->getMyFeed($limitFeeds);
             
           
            ////////////////////////////////////должно запускаться при любой активности юзера
               //если пользователь существует в хэше, обновим его expire time
                Yii::$app->onLineUsers->writeTime($currentUser->id);
        }else{
            $myFeeds = NULL;
            $currentUser = NULL;
        }
        
       
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('stateUsers')){
             $stateUsers = $session->get('stateUsers');
             $limitUsers = $stateUsers;
         }else{
             $session->set('stateUsers', Yii::$app->params['usersToShow']);
             $limitUsers = $session->get('stateUsers');
         }
        $users = User::getUsersWithLimit($limitUsers);
        
        return $this->render('index',[
            'users' => $users,
            'myFeeds' => $myFeeds,
            'limit' => $limitUsers,
            'currentUser' => $currentUser,
        ]);
    }
    
    
    public function actionAddUsers()
    {
          
        $limit = Yii::$app->params['feedPostLimit'];
        if (!Yii::$app->user->isGuest){
            /* @var $currentUser User */
            $currentUser = Yii::$app->user->identity;
            
//            $myFeeds = Yii::$app->cache->get('cached_myFeeds');
//            if ($myFeeds === false) {
//                $myFeeds = $currentUser->getMyFeed($limit);
//                Yii::$app->cache->set('cached_myFeeds',$myFeeds , 30);
//            }
            $session = Yii::$app->session;
        $session->open();
        if ($session->has('stateFeeds')){
             $stateFeeds = $session->get('stateFeeds');
             $limitFeeds = $stateFeeds;
         }else{
             $session->set('stateFeeds', Yii::$app->params['feedsToShow']);
             $limitFeeds = $session->get('stateFeeds');
         }
                $myFeeds = $currentUser->getMyFeed($limitFeeds);
           
        }else{
            $myFeeds = NULL;
            $currentUser = NULL;
        }
        
        $session = Yii::$app->session;
        $session->open();
        
        if ($session->has('stateUsers')){
             $stateUsers = $session->get('stateUsers');
             $stateUsers +=Yii::$app->params['usersToShow'];
             $session->set('stateUsers', $stateUsers);
             $limitUsers = $stateUsers;
         }else{
             $session->set('stateUsers', Yii::$app->params['usersToShow']);
             $limitUsers = $session->get('stateUsers');
         }
        
         $users = User::getUsersWithLimit($limitUsers);
        
        return $this->render('index',[
            'users' => $users,
            'myFeeds' => $myFeeds,
            'limit' => $limitUsers,
            'currentUser' => $currentUser,
        ]);
         
    }
    public function actionAddFeeds()
    {
          
        //$limit = Yii::$app->params['feedPostLimit'];
        if (!Yii::$app->user->isGuest){
            /* @var $currentUser User */
            $currentUser = Yii::$app->user->identity;
             
             $session = Yii::$app->session;
             $session->open();
             if ($session->has('stateFeeds')){
             $stateFeeds = $session->get('stateFeeds');
             $stateFeeds +=Yii::$app->params['feedsToShow'];
             $session->set('stateFeeds', $stateFeeds);
             $limitFeeds = $stateFeeds;
         }else{
             $session->set('stateFeeds', Yii::$app->params['feedsToShow']);
             $limitFeeds = $session->get('stateFeeds');
         }
                $myFeeds = $currentUser->getMyFeed($limitFeeds);
              
           
        }else{
            $myFeeds = NULL;
            $currentUser = NULL;
        }
      
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('stateUsers')){
             $stateUsers = $session->get('stateUsers');
             $limitUsers = $stateUsers;
         }else{
             $session->set('stateUsers', Yii::$app->params['usersToShow']);
             $limitUsers = $session->get('stateUsers');
         }
        $users = User::getUsersWithLimit($limitUsers);
        
        
        
        return $this->render('index',[
            'users' => $users,
            'myFeeds' => $myFeeds,
            'limit' => $limitUsers,
            'currentUser' => $currentUser,
        ]);
         
    }
   public function actionSessionExperinent()
   {
      // Yii::$app->cache->flush();
       $number = Yii::$app->cache->get('cached_number');
       if ($number === false) {
       
        $number = self::generate();

        Yii::$app->cache->set('cached_number', $number, 30);
       }
   
       return $this->render('cache',[
            'number' => $number,
       ]);
      
   }
   
   public static function generate()
   {
       sleep(4);
       return rand(1,100);
   }

   public function actionAbout()
    {
       
        return $this->render('about',[
          
        ]);
    }
    
    
    public function actionLanguage()
    {
       $language = Yii::$app->request->post('language');
       Yii::$app->language = $language;
       
       $languageCookie = new Cookie([
           'name' => 'language',
           'value' => $language,
           'expire' => time() + 60 * 60 *24 *30//30 days
       ]);
       Yii::$app->response->cookies->add($languageCookie);
               
       return $this->redirect(Yii::$app->request->referrer);//вернём пользователя туда где он находился
    }
   
}

