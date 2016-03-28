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
            <?php foreach($this->params['menuData'] as $menu){ 
                $subMenu_path = [];
                if(isset($menu['subMenu'])){
                    foreach($menu['subMenu'] as $submenu){
                        $subMenu_path = array_merge($submenu['path'], $subMenu_path);
                    }
                }
                $inter=array_intersect($this->params['requestUrl'], $subMenu_path);
            ?>
                <?php if(in_array($menu['path'], $this->params['requestUrl']) || !empty($inter)){ //控制是否显示模块 ?>    
                    
                    <li <?php if((isset($menu['controller']) && preg_match('/\b'.$this->context->id.'\b/', $menu['controller'])) !== false){ ?>class="active"<?php } ?>>
                        <a href="/<?= $menu['path']; ?>">
                            <i class="fa <?= $menu['icon']; ?>"></i>&nbsp;&nbsp;&nbsp;
                            <span class="nav-label"><?= $menu['name']; ?></span><?php if(isset($menu['subMenu']) && count($menu['subMenu']) > 0){ ?><span class="fa arrow"></span><?php } ?>
                        </a>
                        <?php if(isset($menu['subMenu']) && count($menu['subMenu']) > 0){ ?>
                            <ul class="nav nav-second-level">
                                <?php foreach($menu['subMenu'] as $submenu){ ?>
                                    <li <?php if(in_array($this->context->id.'/'.$this->context->action->id, $submenu['path'])){ ?>class="active"<?php } ?>><a href="/<?= $submenu['path'][0]; ?>"><?= $submenu['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        
                    
                    </li>
                
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</aside>