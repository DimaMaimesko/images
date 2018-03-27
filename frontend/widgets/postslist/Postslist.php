<?php
namespace frontend\widgets\postslist;
use yii\base\Widget;
use frontend\modules\post\models\Post;
use Yii;
/**
 * Description of Postslist
 *
 * @author дз
 */
class Postslist extends Widget{
    //put your code here
    public $id = null;
    public function run()
    {
        $currentUserId = Yii::$app->user->id;//будем использовать для вывода кнопок Like и Dislike
        
        
        $postsList = new Post();
        $postsList = $postsList->getUserPosts($this->id);
        if ($postsList){
             //Yii::$app->session->setFlash('success', 'New post added');
        } 
        else{
           //Yii::$app->session->setFlash('danger', 'Error!');  
        }
        return $this->render('index',[
           'postsList' => $postsList, 
           'currentUserId' => $currentUserId, 
        ]); 
    }
}
