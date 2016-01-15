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
<?= Html::cssFile('@web/static/plugins//toastr/build/toastr.min.css'); ?>

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
                <li class=""><a data-toggle="tab" href="#tab-1">任务参数</a></li>
                <li class="active"><a data-toggle="tab" href="#tab-2">任务状态</a></li>
                <!--根据job_status判断是否显示终止任务按钮-->
<!--
                <button class="btn-outline w-xs btn-danger col-lg-offset-8" onclick='javascript:stop_task("");'>终止任务</a></button>
-->
<?php
if ($job_status == 1) {
    echo '<button class="btn-outline w-xs btn-danger col-lg-offset-8" onclick=\'javascript:stop_task("'.$job_id.'");\'>终止任务</a></button>';
}
?>

            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane">
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
<?php
foreach ($job_config as $v) {
    echo "<tr>";
    echo "<td>".$v['type']."</td>";
    echo "<td>".$v['name']."</td>";
    echo "<td>".$v['value']."</td>";
    echo "</tr>";
}
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane active">
                    <div class="panel-body">
                        <div class="hpanel">
                            <div class="panel-heading">
                                <div id="taskstatus" class="alert" style="color:#FFFFFF">
                                    <div class="row">
                                        <div class="col-lg-1">当前状态:</div><div id="statuscontent" class="col-lg-2">failed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 任务状态-->
                        <div class="hpanel hblue">
                            <div class="panel-heading">
                            <h5>任务日志下载链接：<a style="text-decoration:underline" href="<?php echo $log_url;?>"><?php echo $log_url;?></a></h5>
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
                                    </tbody>
                                </table>
                                </div>
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
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>

<script type="text/javascript">
$(function() {
     toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "positionClass": "toast-top-center",
                "closeButton": true,
                "debug": false,
                "toastClass": "animated fadeInDown",
            };
});

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
            $.ajax({
                type: 'POST',
                url: '/task/killjob',
                dataType: 'json',
                data: {'job_id': id},
                success: function(json) {
                    if (json.status == 10000) {
                        toastr.success("终止任务成功！");
                        window.location.href="/task/detail?job_id="+id;
                    } else {
                        swal({
                            title: "操作失败",
                            text: json.description,
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "#e74c3c",
                            confirmButtionText: "确认",
                            closeOnConfirm: false,
                        });
                    }
                }
            });
        } else {

        }

    });
}


//var job_id = 122;
var job_id = <?php echo $job_id;?>;
var setIntervalFun = null;
window.onload = function () {
    setIntervalFun = setInterval("checkJobStatus(job_id)", 1000*7);
    checkJobStatus(job_id);
}
//根据job_id查询当前job的状态,并根据job_status 判断是否需要轮询
function checkJobStatus(id) {
    $.post(
        "/task/jobstatus",
        {job_id:id},
        function(json) {
            if (json.status == 10000) {
                var job_info = eval(json.data);
                //清空table内容
                $("#task_body").html("");
                //更新job 状态
                updateJobStatus(job_info.status);
                if(job_info.status != 1) {
                    clearInterval(setIntervalFun);
                }                
                //更新table 中task 的信息
                showTasksTable(job_info.tasks);
            } else {
                clearInterval(setIntervalFun);
                swal({
                    title: "操作失败",
                    text: json.description,
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#e74c3c",
                    confirmButtionText: "确认",
                    closeOnConfirm: false,
                });
            }
        },"json"
    );
}

//更改job status 页面显示,status为当前job的状态1，2，3
function updateJobStatus(status) {
    switch(status){
        case 0:
            //create
            document.getElementById("taskstatus").style.backgroundColor = "#9b59b6";
            document.getElementById("statuscontent").textContent = "创建";
            break;
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
        case 4:
            document.getElementById("taskstatus").style.backgroundColor = "#e74c3c";
            document.getElementById("statuscontent").textContent = "执行终止";
            break;
    }
}

//显示job下的所有task状态，动态绘制table
function showTasksTable(arr) {
    var tbody = document.getElementById("task_body");
    if (!(arr instanceof Array)) {
        return ;
    }
    for (var i=0; i<arr.length; i++) {
        var row = document.createElement('tr');
        //防止后台返回的数据顺序和table不一致，不用for
        var name_c = document.createElement('td');
        var name = document.createTextNode(arr[i]["name"]);
        name_c.appendChild(name);
        row.appendChild(name_c);
        var status_c = document.createElement('td');
        switch(arr[i]["status"]){
            case 0:
                var m = document.createTextNode("creating");
                break;
            case 1:
                var m = document.createTextNode("running");
                status_c.style.color = "#3498db";
                break;
            case 2:
                var m = document.createTextNode("succeed");
                status_c.style.color = "#62cb31";
                break;
            case 3:
                var m = document.createTextNode("failed");
                status_c.style.color = "#e74c3c";
                break;
            case 4:
                var m = document.createTextNode("skipped");
                status_c.style.color = "#ffb606";
                break;
            case 5:
                var m = document.createTextNode("waiting");
                break;
            default:
                var m = document.createTextNode("");
                break;
        }
        status_c.appendChild(m);
        row.appendChild(status_c);

        var st_c = document.createElement('td');
        if (arr[i]["start_time"] == null) {
            var start_time = document.createTextNode("");
        } else {
            var start_time = document.createTextNode(arr[i]["start_time"]);
        }
        st_c.appendChild(start_time);
        row.appendChild(st_c);

        var fn_c = document.createElement('td');
        if (arr[i]['status'] == 1) {
            var finish_time = document.createElement('img');
            finish_time.setAttribute("src", "/static/images/loading1.gif");
        } else {
            if (arr[i]["finish_time"] == null) {
                var finish_time = document.createTextNode("");
            } else {
                var finish_time = document.createTextNode(arr[i]["finish_time"]);
            }
        }

        fn_c.appendChild(finish_time);
        row.appendChild(fn_c);

        tbody.appendChild(row);
    }
}

</script>
