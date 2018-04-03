<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\modules\post\models\Feed;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $nickname
 * @property string $about
 * @property integer $type
 * @property string $picture
 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const DEFAULT_IMAGE = '/default/default.jpg';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function findUserNameBy($id)
    {
        $identity = self::findIdentity($id);
        return $identity->username;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function getNickname()
    {
        if ($this->nickname){
            return $this->nickname;
        }return $this->getId();
    }
    
    public function findUserById($id)
    {
        if ($user = self::findOne($id))
                return $user;
        throw new \yii\web\NotFoundHttpException();
    }
    
    public function followUser(User $targetUser)
    {
       $redis = Yii::$app->redis;
       $redis->executeCommand('sadd', ['user:'.$this->getId().':subscriptions', $targetUser->getId()]);
       $redis->executeCommand('sadd', ['user:'.$targetUser->getId().':followers', $this->getId()]);
    }
    public function unfollowUser(User $targetUser)
    {
       $redis = Yii::$app->redis;
       $redis->executeCommand('srem', ['user:'.$this->getId().':subscriptions', $targetUser->getId()]);
       $redis->executeCommand('srem', ['user:'.$targetUser->getId().':followers', $this->getId()]);
    }
    
    public function getSubscriptions()
    {
       $redis = Yii::$app->redis;
       $setOfSubscriptions = $redis->executeCommand('smembers', ['user:'.$this->getId().':subscriptions']);
       return User::find()->select('id,username,nickname')->where(['id' => $setOfSubscriptions])->orderBy('username')->asArray()->all();
    }
    public function getNumberOfSubscriptions()
    {
       $redis = Yii::$app->redis;
       return $redis->executeCommand('scard', ['user:'.$this->getId().':subscriptions']);
       
    }
    
    public function getFollowers()
    {
       $redis = Yii::$app->redis;
       $setOfFollowers = $redis->executeCommand('smembers', ['user:'.$this->getId().':followers']);
       return User::find()->select('id,username,nickname')->where(['id' => $setOfFollowers])->orderBy('username')->asArray()->all();
    }
    
    public static function getIdOfFollowers()
    {
       $redis = Yii::$app->redis;
       return  $redis->executeCommand('smembers', ['user:'.Yii::$app->user->id.':followers']);
    }
    
    public  function getNumberOfFollowers()
    {
       $redis = Yii::$app->redis;
       return $redis->executeCommand('scard', ['user:'.$this->getId().':followers']);
    }
    
    public function getFriends()
    {
       $redis = Yii::$app->redis;
       $setOfFriends = $redis->sinter("user:{$this->getId()}:subscriptions","user:{$this->getId()}:followers");
       return User::find()->select('id,username,nickname')->where(['id' => $setOfFriends])->orderBy('username')->asArray()->all();
    }
    public function getNumberOfFriends()
    {
       $redis = Yii::$app->redis;
       $setOfFriends = $redis->sinter("user:{$this->getId()}:subscriptions","user:{$this->getId()}:followers");
       return count($setOfFriends);
    }
    
    public function getPicture()
    {
       if ($this->picture){
           return Yii::$app->storage->getFile($this->picture);
       }
       return self::DEFAULT_IMAGE;
    }
    
    /**
     * Delete picture from user record and file system
     * @return boolean
     */
    public function deletePicture($userId)
    {
        if ($this->picture && Yii::$app->storage->deleteFile($this->picture,$userId)) {
            $this->picture = null;
            return $this->save(false, ['picture']);
        }
        return false;
    }
    /**
     * Get data for newsfeed
     * @param type $limit
     * @return type array
     */
     public  function getMyFeed($limit)
    {
       return  $this->hasMany(Feed::className(), ['user_id' => 'id'])
                    ->asArray()
                    ->orderBy(['post_created_at' => SORT_DESC])
                    ->limit($limit)
                    ->all();
        
    }
     
    
}
