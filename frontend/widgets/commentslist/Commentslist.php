<?php
namespace frontend\widgets\commentslist;
use yii\base\Widget;
use frontend\modules\post\models\Post;
use frontend\modules\post\models\Comment;
use Yii;
/**
 * Description of Postslist
 *
 * @author дз
 */
class Commentslist extends Widget{
    //put your code here
    public $post_id = null;
    public function run()
    {
        $currentUserId = Yii::$app->user->id;//будем использовать для вывода кнопок Like и Dislike
        
        
        $currentPost = new Post();
        $currentPost = $currentPost->getPost($this->post_id);
        $comments = Comment::getCommentsBy($this->post_id);
        //print_r($comments);die;
        return $this->render('index',[
           'currentPost' => $currentPost, 
           'currentUserId' => $currentUserId, 
           'comments' => $comments, 
            
        ]); 
    }
}
