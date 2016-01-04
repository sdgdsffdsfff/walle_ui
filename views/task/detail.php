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
                <!--<a class="col-lg-offset-8" href='javascript:stop_task("123");'><button class="btn-outline w-xs btn-danger">终止任务</button></a>-->
                <button class="btn-outline w-xs btn-danger col-lg-offset-8" onclick='javascript:stop_task("123");'>终止任务</a></button>

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
<!--
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
-->
                                <div id="taskstatus" class="alert" style="color:#FFFFFF">
                                    <div class="row">
                                        <div class="col-lg-1">当前状态:</div><div id="statuscontent" class="col-lg-2">failed</div>
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
                                    <tbody id="task_body">
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

//终止任务
function stop_task(id) {
    swal({
            title: "终止任务确认",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消",
        },
        function(isConfirm){
            if (isConfirm) {
                //调用后台脚本
                alert("终止任务："+id);
            } else {

            }

        });
}


var job_id = 122;//var job_id = <?php echo $job_id;?>;
var setIntervalFun = null;
window.onload = function () {
    checkJobStatus(job_id);
}
setIntervalFun = setInterval("checkJobStatus(job_id)", 1000*7);
//根据job_id查询当前job的状态,并根据job_status 判断是否需要轮询
function checkJobStatus(id) {
    $.post(
        "/task/jobstatus",
        {job_id:id},
        function(json) {
            if (json.result = "success") {
                var job_info = eval(json.data);
                updatePage(job_info.status);
                if(job_info.status != 1) {
                    clearInterval(setIntervalFun);
                }                
            } else {
                alert("error");
            }
        },"json"
    );
}
//动态更新页面显示信息
function updatePage(job_status) {
    updateJobStatus(job_status);
    updateTasks(job_id);
}

//更改job status 页面显示,status为当前job的状态1，2，3
function updateJobStatus(status) {
    switch(status){
        case 1:
            //running
            document.getElementById("taskstatus").style.backgroundColor = "#3498db";
            document.getElementById("statuscontent").textContent = "运行中。。。";
            break;
        case 2:
            //succeed
            document.getElementById("taskstatus").style.backgroundColor = "#62cb31";
            document.getElementById("statuscontent").textContent = "成功";
            break;
        case 3:
            //failed
            document.getElementById("taskstatus").style.backgroundColor = "#e74c3c";
            document.getElementById("statuscontent").textContent = "失败";
            break;
        default:
            break;
    }
}

//显示job 对应的所有task 的状态table,json job对应的task名称，状态，开始时间，结束时间
//{status:"success",data:[{"name":"task1","status":"running","bt":"123142134","et":""},....]}
function showTable(json) {
    if (json.status == "success") {
        var tbody = document.getElementById("task_body");
        var tasks = eval(json.data);
        for(var i=0; i<tasks.length; i++) { 
            var row = document.createElement('tr');
            //var row = document.createElement_x('tr');
            for(var key in tasks[i]) {
                var c = document.createElement('th');
                var m = document.createTextNode(tasks[i][key]);
                c.appendChild(m);
                row.appendChild(c);
            }
            tbody.appendChild(row);
        }
    }
}

function updateTasks(id) {
    $.post(
        "/task/tasksinfo",
        {job_id:id},
        function(json) {
            showTable(json)
        },"json"
    );
}

</script>
