<?php


namespace frontend\models;
use Intervention\Image\ImageManager;
use yii\base\Model;
/**
 * Description of Images
 *
 * @author дз
 */
class Images extends Model{
    //put your code here
    /**
     * @param type $image
     * @param type $width
     * @param type $height
     * @return type
     */
    public static function resizeImage($image, $width=400, $height=400)
    {
        // create an image manager instance with favored driver
        $manager = new ImageManager(array('driver' => 'imagick'));
        // to finally create image instances
        $image = $manager->make($image);
        $widthReal = $image->width();
        $heightReal = $image->height();
        return $manager->make($image)->resize($widthReal/10, $heightReal/10);
    }
}
