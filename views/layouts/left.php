<?php
use yii\helpers\Html;
?>
<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <?= Html::img('@web/static/images/av3.png', ['class' => 'img-circle m-b', 'alt' => 'logo','style' => 'width:60px;height:60px;']); ?>
            </a>
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo Yii::$app->getUser()->getIdentity()->name?></span>
               
            </div>
             <small class="text-muted">欢迎进入WALLEUI系统</small>
        </div>
        <ul class="nav" id="side-menu">
            <?php foreach($this->params['menuData'] as $menu){ ?>
                <?php if(in_array($menu['path'], $this->params['requestUrl'])){ ?>
                    <li <?php if(($this->context->id.'/'.$this->context->action->id) == $menu['path']){ ?>class="active"<?php } ?>>
                        <a href="/<?= $menu['path']; ?>"><i class="fa <?= $menu['icon']; ?>"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label"><?= $menu['name']; ?></span></a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</aside>