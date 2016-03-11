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
<style type="text/css">
.glyphicon { cursor: pointer; }
</style>
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
			</div>
			<div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
				<table id="package_table" cellpadding="1" cellspacing="1" class="js-dynamitable table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>
                                安装包名称
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
							<th>
                                操作
                                <span class="js-sorter-desc glyphicon glyphicon-chevron-down pull-right"></span>
                                <span class="js-sorter-asc glyphicon glyphicon-chevron-up pull-right"></span>
                             </th>
						</tr>
                    <tr>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($data){ ?>
<?php
$package_names = array();
foreach ($data as $packageConfig) {
    $package_names[] = $packageConfig['package_name'];
}
$package_names = array_unique($package_names);
?>
                                    <?php foreach($package_names as $package_name){ ?>
                                    <option value="<?= $package_name; ?>"><?= $package_name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($data){ ?>
<?php
$parameters = array();
foreach ($data as $packageConfig) {
    $parameters[] = $packageConfig['parameter_des']."（".$packageConfig['parameter_name']."）";
}
$parameters = array_unique($parameters);
?>
                                    <?php foreach($parameters as $parameter){ ?>
                                    <option value="<?= $parameter; ?>"><?= $parameter; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th>
                            <select class="js-filter js-source-states">
                                <option value="">全部</option>
                                <?php if($data){ ?>
<?php
$values = array();
foreach ($data as $packageConfig) {
    $values[] = $packageConfig['value'];
}
$values = array_unique($values);
?>
                                    <?php foreach($values as $value){ ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </th>
                        <th></th>
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
    echo "<td align='center'>"."<a href='/package/config-edit?package_id=".$packageConfig['package_id']."&parameter_id=".$packageConfig['parameter_id']."' class='btn btn-info'>编辑</a>".'<button class="btn btn-danger" onclick="javascript:delete_packageconfig('.$packageConfig['package_id'].",".$packageConfig['parameter_id'].');">删除</button>'."</td>";
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
<?= Html::jsFile('@web/static/dynamitable.jquery.min.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2({
        width: '100%'
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
                url: '/package/config-delete',
                data: 'package_id='+package_id+'&parameter_id='+parameter_id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 10000) {
                        swal({
                            title: data.description,
                            type: "success",
                            showCancelButton: false, //是否显示'取消'按钮
                            confirmButtonColor: "#e74c3c",
                            confirmButtonText: "确认",
                            closeOnConfirm: false
                        },
                        function(){
			                window.location.href="/package/config-list";
                        });
                    } else if (data.status == 40003) {
                        swal({
                            title: "权限提示",
                            text: data.description,
                            type: "warning",
                            showCancelButton: false, //是否显示'取消'按钮
                            confirmButtonColor: "#e74c3c",
                            confirmButtonText: "确认",
                            closeOnConfirm: false
                        });
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