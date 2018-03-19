<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use frontend\models\Images;
/**
 * File storage compoment
 *
 * @author admin
 */
class Storage extends Component implements StorageInterface
{

    private $fileName;
    private $path_small;
    private $userID;
    /**
     * 
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
       return Yii::$app->params['storageUriResized'].$filename;
    }
    /**
     * Save given UploadedFile instance to disk
     * @param UploadedFile $file
     * @return string|null
     */
    public function saveUploadedFile(UploadedFile $file, $userID)
    {
        $this->userID = $userID;
        $path = $this->preparePath($file); 
        $file->saveAs($path['path_small']);
        return [
            'fName' => $this->userID.'/'.$this->fileName,
            'pName' => $file->name,
            'pSize' => $file->size
            ];
    }
     /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string|null
     */
    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);  
        //     0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg
        $this->path_small = $this->getStoragePath() . $this->fileName;  
        //     /var/www/project/frontend/web/uploads/resized/0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg
        $this->path_small = FileHelper::normalizePath($this->path_small);
        
        if (FileHelper::createDirectory(dirname($this->path_small))) {
            return [
                'path_small' => $this->path_small,
                ];
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function getFilename(UploadedFile $file)
    {
        // $file->tempname   -   /tmp/qio93kf
        
        $hash = sha1_file($file->tempName); // 0ca9277f91e40054767f69afeb0426711ca0fddd
        
        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);  // 0c/a9/277f91e40054767f69afeb0426711ca0fddd
        return $name . '.' . $file->extension;  // 0c/a9/277f91e40054767f69afeb0426711ca0fddd.jpg
    }

    /**
     * @return string
     */
    protected function getStoragePath()
    {
       return Yii::getAlias(Yii::$app->params['storagePathResized'].$this->userID.'/');
    }

    /**
     * @param string $filename
     * @return boolean
     */
    public function deleteFile(string $filename, $userId)
    {
        $file = $this->getStoragePath().$filename;
        $dirToFile = $this->getStoragePath();
        $dirToFile = $dirToFile.$userId;
        $dirToFile = FileHelper::normalizePath($dirToFile);
        //print_r($dirToFile);die;
        FileHelper::removeDirectory($dirToFile,true);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }
}
