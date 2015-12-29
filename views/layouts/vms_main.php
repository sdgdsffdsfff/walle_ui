<?php
use yii\helpers\Html;
?>
    <!-- Header-->
    <?= $this->render('header'); ?>

    <!--左侧菜单-->
    <?= $this->render('left'); ?>
    
    <!-- Main Wrapper -->
    <div id="wrapper">
        <?= $content ?>
        
        <!-- Footer-->
        <?= $this->render('footer'); ?>
    </div>
    
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

<?= Html::jsFile('@web/static/homer.js'); ?>