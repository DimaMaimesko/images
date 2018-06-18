<?php

namespace app\modules\geolocation\models;

use Yii;
use frontend\models\User;
/**
 * This is the model class for table "geolocation".
 *
 * @property int $id
 * @property int $user_id
 * @property string $latLng
 * @property int $time
 * @property int $status
 */
class Geolocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geolocation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'time'], 'required'],
            [['user_id', 'time', 'status'], 'integer'],
            [['latLng'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'latLng' => 'Lat Lng',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }
    
    public function writeOrNot($currentUser,$latLngJson){
        $userLocation = self::find()->where(['user_id' => $currentUser])->one();
        if ($userLocation) { //если запись существует
           if ($latLngJson === $userLocation->latLng){//нужно ли обновить
               return false;//координаты не изменились - обновлять не нужно 
           }else{//координаты изменились - обновляем
               $userLocation->latLng = $latLngJson;
               $userLocation->update();
               return true;
           }
        } else {//если записи еще не было - создадим её
             $this->user_id = $currentUser;
             $this->latLng = $latLngJson;
             $this->time = time();
             if ($this->validate() && $this->save ())  {
                  return true;
             }else{
                 return false;
             }
          }
    }
    
    public function fetchFriendsParams($friendsIds)
    {
        return $this->find()->where(['user_id' =>$friendsIds])->asArray()->all();
    }
    
    public function addParamsFromUser($arrFromGeolocation)
    {
        foreach ($arrFromGeolocation as $key => $item) {
            $user = User::findIdentity($item['user_id']);
            if ($user){
                 array_push($arrFromGeolocation[$key],$user->username, $user->picture);
            }
           
        }
        return $arrFromGeolocation;
    }
    
    public function getFriend()
    {
        return $this->hasOne(Geolocation::className(), ['id' => 'user_id']);
    }
}