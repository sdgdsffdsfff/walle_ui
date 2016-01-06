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
use \yii\widgets\LinkPager;
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
                    <div class="form-group col-md-3">
                        <label class="control-label">版本号：</label>
                        <input type="text" name="version" class="form-control" placeholder="版本号">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">发布人：</label>
                        <input type="text" name="release_user" class="form-control" placeholder="发布人">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">发布位置：</label>
                        <select class="js-source-states" name="deployment_id" style="width:200px">
                            <optgroup label="请选择发布位置">
                                <option value="1">appstoreonline</option>
                                <option value="2">appstoretest</option>
                                <option value="3">mixonline</option>
                                <option value="4">mixtest</option>
                                <!---  php foreach work table-->
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-2"><button class="btn w-xs btn-warning" type="submit">查询</button></div>
                </form>
            </div>
         </div>
     </div>
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-body">
                <div class="table-responsive">
                  <div style="float:right">
                    <?php echo LinkPager::widget([
    'pagination' => $pages
]); ?>
              </div>
              <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
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
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">122</a></td>
                        <td>96</td>
                        <td>appstoreonline</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                        <td>96</td>
                        <td>appstoretest</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a href='javascript:stop_task("123");'><button class="btn-outline btn-sm btn-danger stoptask">终止任务</button></a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                        <td>96</td>
                        <td>mixonline</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a href='javascript:stop_task("123");'><button class="btn-outline btn-sm btn-danger stoptask">终止任务</button></a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                        <td>96</td>
                        <td>mixtest</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a href='javascript:stop_task("123");'><button class="btn-outline btn-sm btn-danger stoptask">终止任务</button></a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                        <td>96</td>
                        <td>mixonline</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a href='javascript:stop_task("123");'><button class="btn-outline btn-sm btn-danger stoptask">终止任务</button></a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail">123</a></td>
                        <td>96</td>
                        <td>mixtest</td>
                        <td>2015-12-28 22:22:10</td>
                        <td></td>
                        <td>运行中</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td><a href='javascript:stop_task("123");'><button class="btn-outline btn-sm btn-danger stoptask">终止任务</button></a></td>
                    </tr>
                    <tr>
                        <td><a style="text-decoration:underline" href="/task/detail?job_id=122">122</a></td>
                        <td>96</td>
                        <td>mixonline</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
  <div style="float:right">
                    <?php echo LinkPager::widget([
    'pagination' => $pages
]); ?>
              </div>
              <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
                </div>

            </div>
        </div>

    </div>
</div> <!--list content div-->

</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>

<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
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
                alert("终止任务："+id);
            } else {

            }

        });
}
</script>
