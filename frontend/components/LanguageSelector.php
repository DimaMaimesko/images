<?php

namespace frontend\components;
use yii\base\BootstrapInterface;
/**
 * Description of LanguageSelector
 *
 * @author дз
 */
class LanguageSelector implements BootstrapInterface {
    //put your code here
    public $supportedLanguages = ['en-US','ru-RU'];
    
    public function bootstrap($app) {
        $cookieLanguage = $app->request->cookies['language'];
        if (isset($cookieLanguage) && in_array($cookieLanguage, $this->supportedLanguages)){
            $app->language = $app->request->cookies['language'];
        }
    }
}
