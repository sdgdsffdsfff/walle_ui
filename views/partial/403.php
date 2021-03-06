<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Page title -->
        <title>WALLEUI</title>
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
        <?php if($flag){ ?>
        <div class="back-link">
            <a href="/" class="btn btn-primary">返回首页</a>
        </div>
        <?php } ?>
        <div class="error-container">
            <i class="pe-7s-way text-success big-icon"></i>
            <h1>403</h1>
            <strong>您没有权限访问，请联系系统管理员！</strong>
            <p></p>
            <?php if($flag){ ?><a href="/" class="btn btn-xs btn-success">返回首页</a><?php } ?>
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