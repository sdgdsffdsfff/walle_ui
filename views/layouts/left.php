<?php
use yii\helpers\Html;
?>
<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <?= Html::img('@web/static/images/profile.jpg', ['class' => 'img-circle m-b', 'alt' => 'logo']); ?>
            </a>
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">Robert Razer</span>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="/version/list"><span class="nav-label">版本列表</span></a>
            </li>
            <li>
                <a href="/version/add-version"><span class="nav-label">创建版本</span></a>
            </li>
            <li>
                <a href="#"><span class="nav-label">创建发布任务</span></a>
            </li>
            <li>
                <a href="#"><span class="nav-label">发布任务列表</span></a>
            </li>
            <li>
                <a href="#"><span class="nav-label">安装包下载</span></a>
            </li>
            <li>
                <a href="#"><span class="nav-label">更新模块版本列表</span></a>
            </li>
        </ul>
    </div>
</aside>