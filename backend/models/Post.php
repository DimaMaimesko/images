<?php

namespace backend\models;


/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $caption
 * @property string $content
 * @property string $photo
 * @property int $created_at
 * @property int $status
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'caption' => 'Cap',
            'content' => 'Content',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    
    public static function findComplaints()
    {
        return self::find()->where('report > 0')->orderBy('report DESC');
        
    }
    
  
}
