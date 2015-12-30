<?php

use yii\helpers\Html;

$this->title = 'WALLE-VI';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta http-equiv="Refresh" content="<?php echo $waitSecond;?>; url=<?php echo $jumpUrl;?>"/>
    <!-- Page title -->
    <title>HOMER | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <?= Html::cssFile('@web/static/plugins/fontawesome/css/font-awesome.css'); ?>
    <?= Html::cssFile('@web/static/plugins/metisMenu/dist/metisMenu.css'); ?>
    <?= Html::cssFile('@web/static/plugins/animate.css/animate.css'); ?>
    <?= Html::cssFile('@web/static/plugins/bootstrap/dist/css/bootstrap.css'); ?>

    <!-- App styles -->
    <?= Html::cssFile('@web/static/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css'); ?>
    <?= Html::cssFile('@web/static/fonts/pe-icon-7-stroke/css/helper.css'); ?>
    <?= Html::cssFile('@web/static/styles/style.css'); ?>

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special AngularJS Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p>
            </a>
 </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="back-link">
    <a href="/" class="btn btn-primary">返回首页</a>
</div>
<div class="error-container">
    <i class="pe-7s-way text-success big-icon"></i>
    <h1>ERROR</h1>
    <strong><?php echo Html::encode($message);?></strong>
    <p>
        <?php echo $waitSecond ?></span>秒后自动跳转，如果不想等待，<a href="<?php echo $jumpUrl; ?>">直接点击这里</a>
    </p>
    <a href="/" class="btn btn-xs btn-success">返回首页</a>
</div>

<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/plugins/jquery/dist/jquery.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-ui/jquery-ui.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/slimScroll/jquery.slimscroll.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/metisMenu/dist/metisMenu.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/iCheck/icheck.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sparkline/index.js'); ?>
<!-- App scripts -->
<?= Html::jsFile('@web/static/homer.js'); ?>
</body>
</html>