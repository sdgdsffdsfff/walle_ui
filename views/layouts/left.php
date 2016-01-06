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
            <li class="active">
                <a href="/index/index"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">首页</span></a>
            </li>
            <li>
                <a href="/version/list"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">版本列表</span></a>
            </li>
            <li>
                <a href="/version/add-version"><i class="fa pe-7s-news-paper"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">创建版本</span></a>
            </li>
            <li>
                <a href="/task/publish"><i class="fa fa-volume-up"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">创建发布任务</span></a>
            </li>
            <li>
                <a href="/task/list"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">发布任务列表</span></a>
            </li>
            <li>
                <a href="/clientpackage/list"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">安装包下载</span></a>
            </li>
            <li>
                <a href="/module/index"><i class="fa fa-stack-exchange"></i>&nbsp;&nbsp;&nbsp;<span class="nav-label">更新模块版本列表</span></a>
            </li>
        </ul>
    </div>
</aside>