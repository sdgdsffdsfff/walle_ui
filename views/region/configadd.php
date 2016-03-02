<?php
/**
* configadd.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2016 www.playcrab.com
* 
* Changelog:
* 2016-02-23 - created
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
                编辑发行地区配置
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
	<div class="col-lg-10">
        <div class="hpanel">
            <div class="col-xs-5 col-md-4"></div>
            <div class="col-xs-5 col-md-7">
                <div class="panel-body">
                    <form id="edit_regionconfig_form" method="get" class="form-horizontal">
                        <div class="table-responsive">
                            <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>字段</th>
                                        <th>取值</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="control-label">发行地区：</label>
                                        </td>
                                        <td>                                               
                                            <select name="region_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                            <optgroup label="">
<?php
if (isset($regionList) && !empty($regionList)) {//新增配置，提供全部发行地区供选择
    echo '<option value="">请选择发行地区</option>';
    foreach ($regionList as $reg) {
        echo '<option value="'.$reg['id'].'">'.$reg['name'].'</option>';
    }
}
?>
                                            </optgroup>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">参数：</label>
                                        </td>
                                        <td>
                                            <select name="parameter_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                            <optgroup label="">
<?php
if (isset($parameterList) && !empty($parameterList)) {
    echo '<option value="">请选择配置参数</option>';
    foreach ($parameterList as $param) {
        echo "<option value='" . $param['id'] . "'>" . $param['description']."(".$param['name'].")" . "</option>";
    }
}
?>
                                            </optgroup>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">参数值：</label>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="parameter_value" name="parameter_value" placeholder="参数值" style="width:300px; margin-right: 40px;"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-5">
                                <button id="create_worker_btn" class="btn btn-success" type="submit">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-center",
            "closeButton": true,
            "toastClass": "animated fadeInDown"
        };
});
</script>
