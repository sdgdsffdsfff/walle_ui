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
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>

<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                发布任务列表
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <form method="get" class="form-inline">
                        <div class="form-group">
                            <label class="control-label">版本号：</label>
                            <input type="text" name="version_id" class="form-control" placeholder="版本号" style="margin-right: 40px;" value="<?php echo $version_id;?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">发布人：</label>
                            <input type="text" name="create_user" class="form-control" placeholder="发布人" style="margin-right: 40px;" value="<?php echo $create_user;?>"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">发布位置：</label>
                            <select class="js-source-states" name="deployment_id" style="width:200px; margin-right: 40px;">
                                <optgroup label="请选择发布位置">
                                    <option value="">请选择发布位置</option>
                                    <!---  php foreach work table-->
<?php
foreach ($deployments as $deployment) {
    if ($deployment_id == $deployment['id']) {
        echo "<option value='" . $deployment['id'] . "' selected>" . $deployment['name'] . "</option>";
    } else {
        echo "<option value='" . $deployment['id'] . "'>" . $deployment['name'] . "</option>";
    }
}
?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn w-xs btn-warning" type="submit">查询</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 10px;">
                    <div style="float:right">
                        <?php echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div>
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $page_count;?> /总记录数：<?php echo $total_count;?></div>
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>任务号</th>
                                <th>版本号</th>
                                <th>发布位置</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>状态</th>
                                <th>发布人</th>
                                <th>发布目标</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
foreach ($job_list as $job) {
    $targets = explode(',', $job['target_tasks']);
    foreach ($targets as $v) {
        $target .= $v."</br>";
    }
    switch($job['status']){
    case 0:
        $status = "创建";
        $operate = "";
        break;
    case 1:
        $status = "执行中";
        $operate = '<a href="javascript:stop_task(\''.$job['id'].'\');">'."<button class='btn-outline btn-sm btn-danger stoptask'>终止任务</button></a>";
        break;
    case 2:
        $status = "执行成功";
        $operate = "";
        break;
    case 3:
        $status = "执行失败";
        $operate = "";
        break;
    }
    echo "<tr>";
    echo "<td><a style='text-decoration:underline' href='/task/detail?job_id=".$job['id']."'>".$job['id']."</a></td>";
    echo "<td>".$job['version_id']."</td>";
    echo "<td>".$job['deployment_name']."</td>";
    echo "<td>".$job['create_time']."</td>";
    echo "<td>".$job['finish_time']."</td>";
    echo "<td>".$status."</td>";
    echo "<td>".$job['create_user']."</td>";
    echo "<td>".$target."</td>";
    echo "<td>".$operate."</td>";
    echo "</tr>";
}
?>
<!--
                            <tr>
                                <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                                <td>96</td>
                                <td>appstoretest</td>
                                <td>2015-12-28 22:22:10</td>
                                <td></td>
                                <td>运行中</td>
                                <td>liuhaiyang</td>
                                <td>生成安装包</td>
                                <td><a href='javascript:stop_task("123");'><button class='btn-outline btn-sm btn-danger stoptask'>终止任务</button></a></td>
                            </tr>
-->
                        </tbody>
                    </table>
                    <div style="float:right">
                        <?php echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div>
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $page_count;?> /总记录数：<?php echo $total_count;?></div>
                </div>
            </div>
        </div>
    </div> 
    <!--list content div-->
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
});
//终止任务
function stop_task(id) 
{
    swal({
        title: "终止任务确认",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "确认",
        cancelButtonText: "取消",
    },
    function(isConfirm){
        if (isConfirm) 
        {
            //调用后台脚本
            alert("终止任务："+id);
        } 
        else 
        {

        }
    });
}
</script>
