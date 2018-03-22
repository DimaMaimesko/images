<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\post\models;
use Yii;
use yii\base\Model;
use Intervention\Image\ImageManager;
/**
 * Description of post-form-model
 *
 * @author дз
 */
class PostFormModel extends Model{
    
    public  $photo;
    public  $content;
    
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
    
    public function __construct()
    {
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
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
        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];
        
        $manager = new ImageManager(array('driver' => 'imagick'));
        
        $image = $manager->make($this->photo->tempName);
        // 3-й аргумент - органичения - специальные настройки при изменении размера
        $image->resize($width, $height, function ($constraint) {
            
            // Пропорции изображений оставлять такими же (например, для избежания широких или вытянутых лиц)
            $constraint->aspectRatio();
            
            // Изображения, размером меньше заданных $width, $height не будут изменены: 
            $constraint->upsize();
            
        })->save();
    }
    
    /**
     * @return integer
     */
    public function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
    
    public function save()
    {
        return 0;
    }
}
