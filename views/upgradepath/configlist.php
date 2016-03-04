<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>
<style type="text/css">
.glyphicon { cursor: pointer; }
</style>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                查看升级序列配置列表
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4">
                    <a href="config-edit" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>
                </div>
            </div>
        </div>
    </div>
    
	<div class="row">
        <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
            <table id="upgrade_path_table" cellpadding="1" cellspacing="1" class="js-dynamitable table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            升级序列
                            <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                            <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span>
                        </th>
                        <th>
                            参数
                            <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                            <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span>
                        </th>
                        <th>
                            参数值
                            <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span> 
                            <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span>
                        </th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <th> 
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($upgradePathSelect){ ?>
                                    <?php foreach($upgradePathSelect as $value){ ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($parameterSelect){ ?>
                                    <?php foreach($parameterSelect as $value){ ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($upgradePathConfigSelect){ ?>
                                    <?php foreach($upgradePathConfigSelect as $value){ ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <?php if($list){ ?>
                <tbody>
                    <?php foreach($list as $config){ ?>
                    <tr>
                        <td><?= $config['upgradePath']['name']; ?></td>
                        <td><?= $config['parameter']['description'].'('.$config['parameter']['name'].')'; ?></td>
                        <td><?= $config['value']; ?></td>
                        <td align="center">
                            <a href="/upgradepath/config-edit?param_id=<?= $config['parameter_id']; ?>&upgradepath_id=<?= $config['upgrade_path_id']; ?>" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>
<?= Html::jsFile('@web/static/dynamitable.jquery.min.js'); ?>
<script type="text/javascript">
$(function() {
    //select2
    $(".js-source-states").select2({ 
        width: '100%' //设定select框宽度
    });

    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown"
    };
});

function delete_regionconfig(region_id, parameter_id) {
	swal({
		title: "删除发行地区相关配置确认",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确认",
		cancelButtonText: "取消"
	},
	function(isConfirm){
		if (isConfirm) {
			//ajax调用后台脚本,根据ajax返回结果提示成功、失败
			toastr.success("删除成功！");
			window.location.href="/region/config-list";
		} else {

		}
	});
}
</script>