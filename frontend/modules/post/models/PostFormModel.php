<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\post\models;
use Yii;
use yii\base\Model;
use frontend\modules\post\models\Post;
use frontend\models\User;
use Intervention\Image\ImageManager;
use frontend\models\events\PostCreatedEvent;
/**
 * Description of post-form-model
 *
 * @author дз
 */
class PostFormModel extends Model{
    
    public  $photo;
    public  $content;
    public $user;
   
    
    const EVENT_POST_CREATED = 'post_created';
    
     public function rules()
    {
        return [
            
            [['photo'], 'file',
              'extensions' => ['jpg'],
              'checkExtensionByMimeType' => true,
              'maxSize' => $this->getMaxFileSize(),  
            ],
             ['content', 'required'],
           
        ];
    }
    
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);//определяем обработчик события After Validate как метод текущего класса resizePicture
       // $this->on(self::EVENT_POST_CREATED, [Yii::$app->FeedService, 'addToFeeds'],$this->user->id);
        $this->on(self::EVENT_POST_CREATED, [Yii::$app->FeedService, 'addToFeeds']);
    }
    
    
    /**
     * Resize image if needed
     */
    public function resizePicture()
    {
        if ($this->photo->error) {
            /* В объекте UploadedFile есть свойство error. Если в нем "1", значит
            * произошла ошибка и работать с изображением не нужно, прерываем
            * выполнение метода */
            return;
        }
        $width = Yii::$app->params['thumbnailPicture']['maxWidth'];
        $height = Yii::$app->params['thumbnailPicture']['maxHeight'];
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->make($this->photo->tempName); // получаем обьект класса Image используя
        // атрибут текущего класса picture(в нём находится обьект класса UploadedFile у которого есть 
        // свойство tempName. Оно соответствует пути на диске по которому храниться изображение(tmp/v43v5vdx).
        // это путь ко временному хранилищу, где оно будет храниться пока мы его не переместим
        // (или до окончания работы скрипта)  ).   
        // 3-й аргумент - органичения - специальные настройки при изменении размера
        $image->resize($width, $height, function ($constraint) {
        // Пропорции изображений оставлять такими же (например, для избежания широких или вытянутых лиц)
        $constraint->aspectRatio();
        // Изображения, размером меньше заданных $width, $height не будут изменены: 
        $constraint->upsize();
        })->crop(200,200)->save();//сохраняем измененное изображение по тому же адрессу tmp/v43v5vdx 
    }
    
    /**
     * @return integer
     */
    public function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
    
    public function save() {
        if ($this->validate()) {//так же выполнится событие EVENT_AFTER_VALIDATE 
            $post = new Post();
            $array = Yii::$app->storage->saveUploadedFile($this->photo, $this->user->id); //  id/ae/a7/8ea26ed7edb60db42d574eb5f4cd6c0deb78.jpg
            $post->photo = $array['fName'];
            $post->content = $this->content;
            $post->user_id = $this->user->id;
            
            if ($post->save(false)) {  
                Yii::$app->session->setFlash('success', 'Photo posted');
                $event = new PostCreatedEvent();
                $event->user = $this->user;
                $event->post = $post;
                $this->trigger(self::EVENT_POST_CREATED, $event);
                return true;
            } else {
                Yii::$app->session->setFlash('danger', 'Error occured while posting');
                return false;
            }
        }
    }
}
