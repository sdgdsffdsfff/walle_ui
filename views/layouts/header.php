<?php
use yii\helpers\Html;
use app\assets\PluginsAsset;

PluginsAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?= Html::csrfMetaTags(); ?>
    <title>WALLEUI系统</title>
    <?php $this->head(); ?>
</head>
<body>
    <?php $this->beginBody(); ?>
    <div id="header">
        <div class="color-line">
        </div>
        <div id="logo" class="light-version">
            <span>
                WALLEUI系统
            </span>
        </div>
        <nav role="navigation">
            <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
            <div class="small-logo">
                <span class="text-primary">WALLEUI</span>
            </div>
            <div class="navbar-right">
                <ul class="nav navbar-nav no-borders">
                    <?php if(yii::$app->session->get('game_name')){ ?>
                    <li class="dropdown" style="margin-top: 14px; margin-right: 10px;">
                        <span class="text-center font-bold"><h5>当前游戏: <?= yii::$app->session->get('game_name'); ?></h5></span>
                    </li>
                    <?php } ?>
                    <li class="dropdown">
                        <a href="/site/logout">
                            <i class="pe-7s-upload pe-rotate-90"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
