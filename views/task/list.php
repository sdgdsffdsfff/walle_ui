<?php
/**
* list.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2015 www.playcrab.com
* 
* Changelog:
* 2015-12-28 - created
* 
*/
use yii\helpers\Html;
$this->title = "";
?>
<div class="content animate-panel">
<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-body">
                <form method="get" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-lg-1 control-label">版本号:</label>
                        <div class ="col-lg-2"><input type="text" name="version" class="form-control"></div>
                        <label class="col-lg-1 control-label">发布机器:</label>
                        <div class ="col-lg-2"><input type="text" name="woker" class="form-control"></div>
                        <label class="col-lg-1 control-label">发布人:</label>
                        <div class ="col-lg-2"><input type="text" name="releaser" class="form-control"></div>
                        <div class ="col-lg-2 col-lg-offset-1"><button class="btn btn-primary" type="submit">查询</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--list content div-->
<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
               <!--
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                This is task list 
            </div>
                -->
            <div class="panel-body">
                <div class="table-responsive">
                <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>任务号</th>
                        <th>版本号</th>
                        <th>发布机器</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                        <th>状态</th>
                        <th>发布人</th>
                        <th>发布目标</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">123</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a style="text-decoration:underline" href="javascript:stoptask();" disabled=true>终止任务</a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">123</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a style="text-decoration:underline" href="javascript:stoptask();" disabled=true>终止任务</a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">123</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a style="text-decoration:underline" href="javascript:stoptask();" disabled=true>终止任务</a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">123</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a style="text-decoration:underline" href="javascript:stoptask();" disabled=true>终止任务</a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>

            </div>
            <div class="panel-footer">
            <!-- 需要使用风格一致的分页-->
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
                    <button class="btn btn-default active">1</button>
                    <button class="btn btn-default">2</button>
                    <button class="btn btn-default">3</button>
                    <button class="btn btn-default">4</button>
                    <button class="btn btn-default">5</button>
                    <button class="btn btn-default">6</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div> <!--list content div-->






</div>
