<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GeolocationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        
        'js/geo.js',
        "https://maps.googleapis.com/maps/api/js?key=AIzaSyCSC2Eca-gleFwSuaLBMMLePnCXoOxoHoo&callback=initMap"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}