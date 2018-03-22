<?php

namespace frontend\modules\post\models;

use Yii;

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
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'created_at', 'status'], 'integer'],
            [['content'], 'string'],
            [['caption', 'photo'], 'string', 'max' => 200],
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
            'caption' => 'Caption',
            'content' => 'Content',
            'photo' => 'Photo',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    
    public function getUserPosts($id)
    {
        return $this->find()->where(['user_id'=>$id])->asArray()->all();
    }
}
