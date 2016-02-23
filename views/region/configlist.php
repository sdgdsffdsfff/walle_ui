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
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                发行地区配置列表
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
	<div class="row">
		<div class="hpanel">
			<div class="panel-body">
				<div class="col-lg-3">
					<button class="btn w-xs btn-warning">新增</button>
				</div>
				<div class="col-lg-5">
					<label class="control-label">upgrade path：</label>
					<select class="js-source-states" name="upgrade_path" style="width:200px; margin-right: 40px;">
						<optgroup label="">
							<option value="">请选择upgrade path</option>
						</optgroup>
					</select>
				</div>
				<div class="col-lg-4">
					<label class="control-label">parameter：</label>
					<select class="js-source-states" name="upgrade_path" style="width:200px; margin-right: 40px;">
						<optgroup label="">
							<option value="">请选择parameter</option>
						</optgroup>
					</select>
			    </div>	
			</div>
			<div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 10px;">
				<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>region</th>
							<th>parameter</th>
							<th>value</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>China</td>
							<td>language</td>
							<td>zh_CN</td>
							<td align="center"><a href="" class=""><button class='btn btn-sm btn-info'>编辑</button></a><a href="" class=""><button class='btn btn-sm btn-danger'>删除</button></a></td>
						</tr>
						<tr>
							<td>China</td>
							<td>language</td>
							<td>zh_CNadfafdsfasfasfasdfasfasdafasasfasfsadfasf</td>
							<td><a href=""><button class='btn btn-sm btn-danger'>删除</button></a></td>
						</tr>
						<tr>
							<td>China</td>
							<td>language</td>
							<td>zh_CN</td>
							<td><a href=""><button class='btn btn-sm btn-danger'>删除</button></a></td>
						</tr>
					</tbody>
				</table>
            </div>

		</div>
	</div>
</div>



<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
     toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "positionClass": "toast-top-center",
                "closeButton": true,
                "debug": false,
                "toastClass": "animated fadeInDown",
            };
});
</script>