<?php

namespace frontend\modules\post\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property int $created_at
 * @property int $status
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id'], 'required'],
            [['post_id', 'user_id', 'created_at', 'status'], 'integer'],
            [['content'], 'string'],
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
            'user_id' => 'User ID',
            'content' => 'Your Comment:',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    
    public static function getCommentsBy($postId)
    {
        $comments = Comment::find()->where(['post_id' => $postId])->all();
       //print_r($postId); die;
        return  $comments;
    }
}
