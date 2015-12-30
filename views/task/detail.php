<?php
/**
* detail.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2015 www.playcrab.com
* 
* Changelog:
* 2015-12-28 - created
* 
*/
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>

<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                任务详情
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">

<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">任务参数</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">任务状态</a></li>
                <button class="btn-outline w-xs btn-danger stoptask col-lg-offset-8">终止任务</button>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                    <div class="hpanel horange">
                    <div class="panel-body">
                        <!-- 任务参数-->
                     <div class="table-responsive">
                            <table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
                                <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>参数名称</th>
                                    <th>参数取值</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>任务参数</td>
                                    <td>发布位置</td>
                                    <td>appstoreonline</td>
                                </tr>
                                <tr>
                                    <td>任务参数</td>
                                    <td>服务器更新包</td>
                                    <td>                                   
                                         <input id="upload_server_update_package" type="checkbox" name="target_tasks" checked value="upload_server_update_package" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td>任务参数</td>
                                    <td>客户端更新包</td>
                                    <td>
                                        90;94;95;101                                   
                                    </td>
                                </tr>
                                <tr>
                                    <td>任务参数</td>
                                    <td>客户端安装包</td>
                                    <td>
                                        tencent.online.ipa<br/>
                                        tentcent.test.ipa<br/>tencent.online.ipa<br/>tentcent.test.ipa<br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>dynamic_config</td>
                                    <td>日志级别</td>
                                    <td>DEBUG</td>
                                </tr>
                                <tr>
                                    <td>dynamic_config</td>
                                    <td>打包机</td>
                                    <td>deploy1.walle.playcrab-inc.com</td>
                                </tr>
                                <tr>
                                    <td>deployment_config</td>
                                    <td>部署位置管理节点主机名</td>
                                    <td>admin.kof.qq.com</td>
                                </tr>
                                <tr>
                                    <td>deployment_config</td>
                                    <td>CDN下载地址前缀</td>
                                    <td>http://asset.playcrab.com/kof/</td>
                                </tr>
                                <tr>
                                    <td>region_config</td>
                                    <td>语言</td>
                                    <td>ko_KR</td>
                                </tr>
                                <tr>
                                    <td>region_config</td>
                                    <td>美术资源源代码路径</td>
                                    <td>/data/work/walle/kof/asset.ko_KR/</td>
                                </tr>
                                <tr>
                                    <td>platform_config</td>
                                    <td>客户端检查版本更新的API地址</td>
                                    <td>http://appstore.kof.playcrab.com/vms/index.php</td>
                                </tr>
                                <tr>
                                    <td>upgrade_path_config</td>
                                    <td>手机操作系统</td>
                                    <td>ios</td>
                                </tr>
                                <tr>
                                    <td>upgrade_path_config</td>
                                    <td>TP规则文件</td>
                                    <td>tp_rule.ios.yaml</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <!-- 任务状态-->
                        <div class="hpanel hblue">
                            <div class="panel-heading">
                                <div class="alert alert-info">
                                    <div class="row">
                                         <div class="col-lg-1">当前状态:</div>
                                         <div class="col-lg-2">
                                         <div class="progress full progress-striped active">
                                             <div style="width:100%" aria-valuemax="50" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-success">
                                             running
                                             </div>
                                         </div>
                                         </div>
                                    </div>
                                </div>
                                <div class="alert alert-success">
                                    <div class="row">
                                        <div class="col-lg-1">当前状态:</div><div class="col-lg-2">succeed</div>
                                    </div>
                                </div>
                                <div class="alert alert-danger">
                                    <div class="row">
                                        <div class="col-lg-1">当前状态:</div><div class="col-lg-2">failed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>状态</th>
                                            <th>开始时间</th>
                                            <th>结束时间</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>create_walle_task</th>
                                            <th>succeed</th>
                                            <th>2015-12-29 11:21:20</th>
                                            <th>2015-12-29 11:21:27</th>
                                        </tr>
                                        <tr>
                                            <th>convert_module_asset</th>
                                            <th>skipped</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>convert_module_script</th>
                                            <th>failed</th>
                                            <th>2015-12-29 11:21:20</th>
                                            <th>2015-12-29 11:21:27</th>
                                        </tr>
                                        <tr>
                                            <th>convert_module_config</th>
                                            <th>running</th>
                                            <th>2015-12-29 11:21:20</th>
                                            <th><i class="fa fa-spinner"></i></th>
                                        </tr>
                                        <tr>
                                            <th>create_package</th>
                                            <th>waiting</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <h5>任务日志下载链接：<a style="text-decoration:underline" href="#">http://walle.playcrab-inc.com/vms/index.php</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>

<script type="text/javascript">
$(function() {
    $('.stoptask').click(function(){
        swal({
                title: "Are you sure?",
                text: "You will stop this task!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, stop it!"
            },
            function(isConfirm){
                if (isConfirm) {
                    //调用后台脚本
                } else {
                    
                }
            
            });
    });

});
</script>
