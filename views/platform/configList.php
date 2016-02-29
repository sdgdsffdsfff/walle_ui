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
                查看平台信息配置列表
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
					<label class="control-label">平台名称：</label>
					<select class="js-source-states" name="upgrade_path" style="width:200px; margin-right: 40px;">
                        <option value="">全部</option>
					</select>
				</div>
				<div class="col-lg-4">
					<label class="control-label">参数：</label>
					<select class="js-source-states" name="upgrade_path" style="width:200px; margin-right: 40px;">
                        <option value="">全部</option>
					</select>
			    </div>	
			</div>
			<div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
				<table id="platform_config_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>平台名称</th>
							<th>参数</th>
							<th>参数值</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>China</td>
							<td>语言(language)</td>
							<td>zh_CN</td>
							<td align="center">
								<a href="/platform/config-edit" class='btn btn-info'>编辑</a>
								<button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$platform_id, $parameter_id";?>");'>删除</button>
							</td>
						</tr>
						<tr>
							<td>China</td>
							<td>语言(language)</td>
							<td>zh_CN</td>
							<td align="center">
								<a href="/platform/config-edit" class='btn btn-info'>编辑</a>
								<button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$platform_id, $parameter_id";?>");'>删除</button>
							</td>
						</tr>
						<tr>
							<td>China</td>
							<td>语言(language)</td>
							<td>zh_CN</td>
							<td align="center">
								<a href="/platform/config-edit" class='btn btn-info'>编辑</a>
								<button class='btn btn-danger' onclick='javascript:delete_regionconfig("<?php echo "$platform_id, $parameter_id";?>");'>删除</button>
							</td>
						</tr>
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
    $('#platform_config_table').dataTable({
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

function delete_regionconfig(region_id, parameter_id) {
	swal({
		title: "删除发行地区相关配置确认",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确认",
		cancelButtonText: "取消",
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