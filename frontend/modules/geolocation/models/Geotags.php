<?php

namespace frontend\modules\geolocation\models;

use Yii;

/**
 * This is the model class for table "geotags".
 *
 * @property int $id
 * @property int $post_id
 * @property double $lat
 * @property double $lng
 * @property int $created_at
 * @property int $status
 */
class Geotags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geotags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'created_at'], 'required'],
            [['post_id', 'created_at', 'status'], 'integer'],
            [['lat', 'lng'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    public static function getLat($postId)
    {
      
        $geotag = self::find()->where(['post_id' => $postId])->one();
        if ($geotag) {
            $lat = $geotag->lat;
            return $lat;
        } else {
                return "";
            }
        
    }
    public static function getLng($postId)
    {
      
        $geotag = self::find()->where(['post_id' => $postId])->one();
        if ($geotag) {
            $lng = $geotag->lng;
            return $lng;
        }else{
            return "";
        }
        
    }
    public static function isGeotagSet($postId)
    {
      
        $geotag = self::find()->where(['post_id' => $postId])->one();
        if (isset($geotag)) {
            return true;
        }else{
            return false;
        }
        
    }
}
