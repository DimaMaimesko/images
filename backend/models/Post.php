<?php

namespace backend\models;
use Yii;
use frontend\modules\post\models\Feed;
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
    public function getImage()
    {
        return Yii::$app->storage->getFile($this->photo);
        
    }
    
    public function approve()
    {
      /* @var $redis Connection*/  
       $redis = Yii::$app->redis;
       $key = "post:{$this->id}:reports";
       $redis->del($key);
       $this->report = 0;
       return $this->save(false,['report']);
    }
    
    public  function deletePost($postId)
    {
        $post = Post::findOne($postId);
        $redis = Yii::$app->redis;
        $key = "post:{$postId}:reports";
          $keyLikes = "post-id:{$postId}";
          $redis->del($keyLikes);
          $keyComments = "ccomment-post-id:{$postId}";
          $redis->del($keyComments);
        return ($post->delete() && Feed::delAllByPostId($postId) &&  $redis->del($key));
        
    }
    
  
}
