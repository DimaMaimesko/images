<?php

namespace frontend\models;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
/**
 * Description of UploadForm
 *
 * @author дз
 */
class UploadForm extends Model {
     /**
     * @var UploadedFile
     */
    public $imageFile; // keeps uloaded file instance
    
    public function rules() {
        return [
            [['imageFile'],'file','extensions' => 'jpg','maxSize' => Yii::$app->params['maxFileSize']],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()){
            if($this->imageFile->saveAs('my_uploads/'.$this->imageFile->baseName.'.'.$this->imageFile->extension)){
                return true;
            }
           
        }
        return false;
    }
}
