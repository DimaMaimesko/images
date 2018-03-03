<?php
namespace frontend\modules\user\components;

use Yii;
use frontend\modules\user\models\Auth;
use frontend\modules\user\models\User;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
/**
 * Description of AuthHandler
 *
 * @author дз
 */
class AuthHandler {
    //put your code here
    private $client;
    
    public function __construct(ClientInterface $client) {//$client - это обьект который знает как взаимодействовать с ресурсом, т.е. с провайдером 
        $this->client = $client;//запоминаем этот обьект в текущем классе
    }
    
    public function handle()//метод вызывается сразу при создании AuthHandler и здесь производится вся основная работа
    {
        if (!Yii::$app->user->isGuest){
            return;
        }
       
        $attributes = $this->client->getUserAttributes(); //обращаемся к провайдеру данных чтобы получить данные пользователя на сайте
        if (isset($attributes['emails'][0]['value']))//если это Google
        {
            $tmp['email'] = $attributes['emails'][0]['value'];
            $tmp['name'] = $attributes['displayName'];
            $tmp['id'] = $attributes['id'];
            $attributes = $tmp;
        }
        if (isset($attributes['login']))//если это GitHub
        {
            $tmp['email'] = $attributes['email'];
            $tmp['name'] = $attributes['login'];
            $tmp['id'] = $attributes['id'];
            $attributes = $tmp;
        }
      
//        echo '<pre>';
//        print_r($attributes);
//        echo '</pre>';
//        echo '<hr>';
//        print_r($attributes['displayName']);
//        echo '<hr>';
//        print_r($attributes['id']);
//        echo '<hr>';
//        print_r($attributes['emails'][0]['value']);
//        
//        
//        die;

        $auth = $this->findAuth($attributes);//выполняем поиск по таблице auth, в $auth будет находится обьект ActiveRecord 
        if ($auth) {
            /* @var User $user */
            $user = $auth->user;//находим обьект пользователя который выполнил вход
            return Yii::$app->user->login($user);
        }
        if ($user = $this->createAccount($attributes)) {
            return Yii::$app->user->login($user);
        }
    }
    
    /**
     * @param array $attributes
     * @return Auth
     */
    private function findAuth($attributes)
    {
        $id = ArrayHelper::getValue($attributes, 'id');
        $params = [
            'source_id' => $id,//идентификатор пользователя в соцсети
            'source' => $this->client->getId(),//название соцсети
        ];
        return Auth::find()->where($params)->one();
    }

    /**
     * 
     * @param type $attributes
     * @return User|null
     */
    private function createAccount($attributes)
    {
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $name = ArrayHelper::getValue($attributes, 'name');

        if ($email !== null && User::find()->where(['email' => $email])->exists()) {
            return;
        }

        $user = $this->createUser($email, $name);

        $transaction = User::getDb()->beginTransaction();
        if ($user->save()) {
            $auth = $this->createAuth($user->id, $id);
            if ($auth->save()) {
                $transaction->commit();
                return $user;
            }
        }
        $transaction->rollBack();
    }

    private function createUser($email, $name)
    {
        return new User([
            'username' => $name,
            'email' => $email,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString()),
            'created_at' => $time = time(),
            'updated_at' => $time,
        ]);
    }

    private function createAuth($userId, $sourceId)
    {
        return new Auth([
            'user_id' => $userId,
            'source' => $this->client->getId(),
            'source_id' => (string) $sourceId,
        ]);
    }
    
    
    
}
