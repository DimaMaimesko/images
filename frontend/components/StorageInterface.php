<?php
namespace frontend\components;
use yii\web\UploadedFile;

/**
 * Description of StorageInterface
 *
 * @author дз
 */
interface StorageInterface {
    //put your code here
    public function saveUploadedFile(UploadedFile $file, $userID);//сохранение файла
    
    public function getFile(string $filename);//получение полного пути файла по его имени
            
            
}
