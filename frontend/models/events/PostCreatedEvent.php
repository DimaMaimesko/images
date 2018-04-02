<?php
namespace frontend\models\events;
use yii\base\Event;
use frontend\models\User;
use frontend\modules\post\models\Post;

/**
 * Description of PostCreatedEvent
 *
 * @author дз
 */
class PostCreatedEvent extends Event{
    //put your code here
    /**
     * @var User 
     */
    public $user;
    /**
     * @var Post 
     */
    public $post;
    
    public function getUser(): User
    {
        return $this->user;
    }
    public function getPost(): Post
    {
        return $this->post;
    }
    
}
