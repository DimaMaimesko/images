<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use common\widgets\Alert;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>

<body>
<?php $this->beginBody() ?>
 <div class="header-top">
                    <div class="container">
                        <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4 brand-logo">
                            <h1>
                                <a href="#">
                                    <img src="/img/logo.png" alt="">
                                </a>
                            </h1>
                        </div>			
                        <div class="col-md-4 col-sm-4 navicons-topbar">
                            <br>
                            <br>                           
                             <ul>
                                <li class="blog-search">
                                    <a href="#" title="Search"><i class="fa fa-search"></i></a>
                                </li>
                                <li>
                                    <?= Html::beginForm(['/site/language']) ?>
                                    
                                    <?= Html::dropDownList('language',Yii::$app->language, ['en-US' => 'English', 'ru-RU' => 'Русский']) ?>
                                    <?= Html::submitButton('Change') ?>
                                    
                                    <?= Html::endForm() ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


    <div class="header-main-nav">
        <div class="container">
            <div class="main-nav-wrapper">
                <nav class="main-menu">
                  
                        <?php
                        $menuItems = [
                            ['label' => Yii::t('about', 'Newsfeed'), 'url' => ['/site/index']],
                        ];
                        if (!Yii::$app->user->isGuest) {
                            $menuItems[] = ['label' => Yii::t('about', 'My page'), 'url' => ['/user/profile/view', 'nickname' => Yii::$app->user->id]];
				  $menuItems[] = ['label' => Yii::t('about', 'Locate me'), 'url' => ['/geolocation/geolocation/index', 'nickname' => Yii::$app->user->id]];
                        }
                        if (Yii::$app->user->isGuest) {
                            $menuItems[] = ['label' => Yii::t('about', 'Signup'), 'url' => ['/user/default/signup']];
                            $menuItems[] = ['label' => Yii::t('about', 'Login'), 'url' => ['/user/default/login']];
                        } else {
                            $menuItems[] = '<li>'
                                    . Html::beginForm(['/user/default/logout'], 'post')
                                    . Html::submitButton(
                                            Yii::t('about', 'Logout ({username})',[
                                                'username' => Yii::$app->user->identity->username
                                            ]) . '  <i class="fa fa-sign-out"></i>', ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    . '</li>';
                        }
                        echo Nav::widget([
                            'options' => ['class' => 'menu navbar-nav navbar-right'],
                            'items' => $menuItems,
                        ]);
                        ?>
                     
                </nav>				
            </div>
        </div>
    </div>
<div class="wrap">
    <?php
//    NavBar::begin([
//        'brandLabel' => Yii::$app->name,
//        'brandUrl' => Yii::$app->homeUrl,
//        'options' => [
//            'class' => 'navbar-inverse navbar-fixed-top',
//        ],
//    ]);
//    $menuItems = [
//        ['label' => 'Home', 'url' => ['/site/index']],
//   
//    ];
//    if (!Yii::$app->user->isGuest) {
//         $menuItems[] = ['label' => 'MyPage', 'url' => ['/user/profile/view','nickname' => Yii::$app->user->id]];
//    }
//    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Signup', 'url' => ['/user/default/signup']];
//        $menuItems[] = ['label' => 'Login', 'url' => ['/user/default/login']];
//    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/user/default/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
//    }
//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav navbar-right'],
//        'items' => $menuItems,
//    ]);
//    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

    <footer class="footer">
       
        <div class="footer">
            <div class="back-to-top-page">
                <a class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
            </div>
            <p class="text">Images | 2017</p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
