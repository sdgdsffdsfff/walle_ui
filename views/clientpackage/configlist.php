<?php
/**
* configlist.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2016 www.playcrab.com
* 
* Changelog:
* 2016-02-22 - created
* 
*/
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<?= Html::cssFile('@web/static/plugins/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                安装包参数配置列表
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
	<div class="row">
		<div class="hpanel">
			<div class="panel-body">
				<div class="col-lg-3">
					<a href="config-edit" class="btn w-xs btn-success">新增</a>
				</div>
				<div class="col-lg-5">
					<label class="control-label">安装包名称：</label>
					<select class="js-source-states" name="package_id" style="width:200px; margin-right: 40px;">
                        <optgroup label="">
                        <option value="">全部</option>
<?php
if (!empty($packages))
{
    foreach ($packages as $package)
    {
        echo "<option value='" . $package['id'] . "'>" . $package['name'] . "</option>";
    }
}
?>
                        </optgroup>
					</select>
				</div>
				<div class="col-lg-4">
					<label class="control-label">参数：</label>
					<select class="js-source-states" name="param_id" style="width:200px; margin-right: 40px;">
                        <optgroup label="">
                        <option value="">全部</option>
<?php
if (!empty($parameters))
{
    foreach ($parameters as $parameter)
    {
        echo "<option value='" . $parameter['id'] . "'>" . $parameter['description']."(".$parameter['name'].")" . "</option>";
    }
}
?>
                        </optgroup>
					</select>
			    </div>	
			</div>
			<div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
				<table id="package_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>安装包名称</th>
							<th>参数</th>
							<th>参数值</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
<?php
foreach ($data as $packageConfig)
{
    echo "<tr>";
    echo "<td>".$packageConfig['package_name']."</td>";
    echo "<td>".$packageConfig['parameter_des']."(".$packageConfig['parameter_name'].")</td>";
    echo "<td>".$packageConfig['value']."</td>";
    echo "<td align='center'>"."<a href='/clientpackage/config-edit?package_id=".$packageConfig['package_id']."&parameter_id=".$packageConfig['parameter_id']."' class='btn btn-info'>编辑</a>".'<button class="btn btn-danger" onclick="javascript:delete_packageconfig('.$packageConfig['package_id'].",".$packageConfig['parameter_id'].');">删除</button>'."</td>";
    echo "</tr>";
}
?>
					</tbody>
				</table>
            </div>
		</div>
	</div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
    //表数据排序
    $('#package_table').dataTable({
        //操作列不排序
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [3] }],
        //去掉分页
        "bPaginate": false,
        //去掉左下角显示记录数
        "bInfo": false,
        //去掉过滤,搜索功能
        "bFilter": false
    });
    
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown"
    };
});

function delete_packageconfig(package_id, parameter_id) {
	swal({
		title: "删除安装包相关配置确认",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确认",
		cancelButtonText: "取消",
	},
	function(isConfirm){
		if (isConfirm) {
			//ajax调用后台脚本,根据ajax返回结果提示成功、失败
            $.ajax({
                type: 'POST',
                url: '/clientpackage/config-delete',
                data: 'package_id='+package_id+'&parameter_id='+parameter_id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 10000) {
                        toastr.success("删除配置成功！");
			            window.location.href="/clientpackage/config-list";
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


</script>
