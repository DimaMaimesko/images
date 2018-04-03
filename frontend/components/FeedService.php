<?php


namespace frontend\components;
use yii\base\Component;
use frontend\modules\post\models\Feed;

/**
 * Description of FeedService
 *
 * @author дз
 */
class FeedService extends Component{
    //put your code here
    
    public function addToFeeds($event)
    {
       //echo "<pre>"; print_r($event);echo "</pre>";die;
        $user = $event->getUser();
        $post = $event->getPost();
        
        $followers = $user->getFollowers();
        foreach ($followers as $follower) {
            $feedItem = new Feed();
            $feedItem->user_id = $follower['id'];
            $feedItem->author_id = $user->id;
            $feedItem->author_name = $user->username;
            $feedItem->author_nickname = $user->getNickname();
            $feedItem->author_picture = $user->getPicture();
            $feedItem->post_id = $post->id;
            $feedItem->post_filename = $post->photo;
            $feedItem->post_description = $post->content;
            $feedItem->post_created_at = $post->created_at;
            $feedItem->save();
            
            
        }
        
    }
}
