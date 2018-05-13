<?php
namespace frontend\components;
use yii\base\Component;
use frontend\models\Session;
use yii\web\Cookie;
use Yii;
/**
 * Description of OnLineUsers
 *
 * @author дз
 */
class OnLineUsers extends Component  {
    //put your code here
    const  EXPIRE_TIME_SEC = 300;
  
    public function isUserOnline($id)
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand('hexists', ['usersonline',$id]);
    }
    
    public function writeTime($id)
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand('hset', ['usersonline',$id,time()+self::EXPIRE_TIME_SEC]);
    }
    
    public function removeUser($id)
    {
        $redis = Yii::$app->redis;
        return $redis->executeCommand('hdel', ['usersonline',$id]);
    }
    
    public function updateUsersonlineHash($hash)
    {
        return self::countActiveGuests($hash);
    }
    
    public function countGuests(){
        $redis = Yii::$app->redis;
        $cookies = Yii::$app->request->cookies;
        if (($cookie = $cookies->get('imagesVisitors')) !== null){//если пользователь уже посещал наш сайт(или сейчас на нем)
            $imagesVisitors = $cookie->value;                    //считываем куку
            self::addToSet($imagesVisitors);                     //добавляем куку и/или обновляем expire 
        }else{                                                  //если пользователь первый раз на сайте
            $imagesVisitors = Yii::$app->security->generateRandomString();//генерируем куку
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new Cookie([                          //записываем куку
                 'name' => 'imagesVisitors',
                 'value' => $imagesVisitors,
            ]));
            self::addToSet($imagesVisitors);                     //добавляем куку в редис на 5 минут
        }
        
        return self::countActiveGuests('imagesvisitors');
    }
    
     private static function addToSet($imagesVisitors)
    {
       $redis = Yii::$app->redis;
       $redis->executeCommand('hset', ['imagesvisitors', $imagesVisitors,time()+self::EXPIRE_TIME_SEC]);
    }
    
    /**
     * 
     * @param string $hashKey
     * @return int 
     */
     private static function countActiveGuests($hashKey)
    {
       
       $redis = Yii::$app->redis;
       $allUsers = $redis->executeCommand('hgetall', [$hashKey]);// получаем массив "thEsjRk" "34234324" "thEsjdRk" "34234324" для 'imagesvisitors'
                                                                 //или "23" "32443243242"  "26" "32443243278" для 'usersonline'
       $keyOrValue = false;
       $usersCounter = 0;
       foreach ($allUsers  as $item) {
           if (!$keyOrValue){ //сформируем пару $key $value из хэша редиса
               $key = $item;
           }else {
               $value = $item;
               if ($value < time()){
                    $redis->executeCommand('hdel', [$hashKey,$key]);//удалим если время вышло
               }else{
                   $usersCounter += 1;                                      
               }
           }
           $keyOrValue = !$keyOrValue;
       }
      return $usersCounter;
      
    }
}
