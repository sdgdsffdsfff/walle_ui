<?php
use yii\helpers\Html;
?>
<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="javascript:void(0);">
                <?= Html::img('@web/static/images/av3.png', ['class' => 'img-circle m-b', 'alt' => 'logo','style' => 'width:60px;height:60px;']); ?>
            </a>
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo Yii::$app->getUser()->getIdentity()->name?></span>
               
            </div>
             <small class="text-muted">欢迎进入WALLEUI系统</small>
        </div>
        <ul class="nav" id="side-menu">
            <?php foreach($this->params['menuData'] as $menu){ ?>
                <li>
                    <a href="<?= $menu['path']; ?>"><i class="fa <?= $menu['icon']; ?>"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label"><?= $menu['name']; ?></span><?php if(count($menu['subMenu']) > 0){ ?><span class="fa arrow"></span><?php } ?></a>
                    <?php if(isset($menu['subMenu']) && count($menu['subMenu']) > 0){ ?>
                        <?php foreach($menu['subMenu'] as $submenu){ ?>
                            <ul class="nav nav-second-level">
                                <li <?php if(($this->context->id.'/'.$this->context->action->id) == $menu['path']){ ?>class="active"<?php } ?>><a href="/<?= $submenu['path']; ?>"><?= $submenu['name']; ?></a></li>
                            </ul>
                        <?php } ?>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</aside>