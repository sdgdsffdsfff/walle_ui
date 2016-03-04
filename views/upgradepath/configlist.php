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
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <option value="chinese">chinese</option>
                                <option value="france">france</option>
                                <option value="Brazie">Brazie</option>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <option value="18">18</option>
                                <option value="16">16</option>
                                <option value="8">8</option>
                            </select>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>B</td>
                        <td>chinese</td>
                        <td>10</td>
                        <td align="center">
                            <a href="/upgradepath/config-edit" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>english</td>
                        <td>18</td>
                        <td align="center">
                            <a href="/upgradepath/config-edit" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>france</td>
                        <td>16</td>
                        <td align="center">
                            <a href="/upgradepath/config-edit" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                    <tr>
                        <td>G</td>
                        <td>spanish</td>
                        <td>8</td>
                        <td align="center">
                            <a href="/upgradepath/config-edit" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>Brazie</td>
                        <td>190</td>
                        <td align="center">
                            <a href="/upgradepath/config-edit" class='btn btn-info'>编辑</a>
                            <button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$region_id, $parameter_id";?>");'>删除</button>
                        </td>
                    </tr>
                </tbody>
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