<?php

namespace frontend\modules\post\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
    
    public function getUserIdBy($postId)
    {
        $post = Post::findOne($postId);
        //print_r($postId); print_r($post->user_id); die;
        return $post->user_id;
    }
    
    
    
    public function getPost($postId)
    {
       
      $post = Post::find()->where(['id' => $postId])->one();
       //print_r($postId); die;
        return  $post;
        
    }
    
    public static function setLikeToPost($postId,$currentUserId)
    {
      $redis = Yii::$app->redis;
      $responce1 = $redis->executeCommand('sadd', ['post-id:'.$postId, 'user-id:'.$currentUserId]);//set содержит юзеров, лайкнувших пост
      $responce2 =  $redis->executeCommand('sadd', ['user-id:'.$currentUserId,'post-id:'.$postId]);//set содержит посты, лайкнутые юзером 
      if ($responce1 && $responce2)
          return true;
      return false;
    }
    public static function delLikeToPost($postId,$currentUserId)
    {
      $redis = Yii::$app->redis;
      $responce1 = $redis->executeCommand('srem', ['post-id:'.$postId, 'user-id:'.$currentUserId]);//set содержит юзеров, лайкнувших пост
      $responce2 =  $redis->executeCommand('srem', ['user-id:'.$currentUserId,'post-id:'.$postId]);//set содержит посты, лайкнутые юзером 
      if ($responce1 && $responce2)
          return true;
      return false;
    }
    public static function getLikes($postId)
    {
      $redis = Yii::$app->redis;
      return  $redis->executeCommand('smembers', ['post-id:'.$postId]);//set содержит юзеров, лайкнувших пост
      
    }
    public static function countLikes($postId)
    {
      $redis = Yii::$app->redis;
      return  $redis->executeCommand('scard', ['post-id:'.$postId]);
      
    }
    public static function isLiked($postId,$currentUserId)
    {
      $redis = Yii::$app->redis;
      return  $redis->executeCommand('sismember', ['post-id:'.$postId,'user-id:'.$currentUserId]);//
      
    }
     public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    Post::EVENT_BEFORE_INSERT => ['created_at'],
                    
                   
                ],
                // если вместо метки времени UNIX используется datetime:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
}
