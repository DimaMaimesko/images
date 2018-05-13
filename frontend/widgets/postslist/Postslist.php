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
    public $view_type = null;
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
        
        
        if ($this->view_type == 1){
            return $this->render('index',[
           'postsList' => $postsList, 
           'currentUserId' => $currentUserId, 
        ]);  
        }
        if ($this->view_type == 2){
             return $this->render('index2',[
           'postsList' => $postsList, 
           'currentUserId' => $currentUserId, 
        ]);  
        }
        if ($this->view_type == 3){
             return $this->render('index3',[
           'postsList' => $postsList, 
           'currentUserId' => $currentUserId, 
        ]);  
        }
       
    }
}

