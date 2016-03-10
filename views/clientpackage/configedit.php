<?php
/**
* configedit.php
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
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>

<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                编辑安装包配置信息
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
                    <form id="edit_packageconfig_form" class="form-horizontal">
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
                                            <label class="control-label">平台：</label>
                                        </td>
                                        <td>                                               
                                            <select name="package_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                            <optgroup label="">
<?php
if (isset($package)) {//编辑配置，只显示要编辑的发行地区
    echo '<option value="'.$package['id'].'" selected="selected">'.$package['name'].'</option>';
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
if (isset($parameter)) {//编辑配置，只显示要编辑的参数
    echo "<option value='" . $parameter['id'] . "' selected='selected'>" . $parameter['description']."(".$parameter['name'].")" . "</option>";
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
<?php
if (isset($parameter) && isset($value)) {//编辑配置，指定参数，根据value_type的类型显示value输入框为input还是select
    switch ($parameter['value_type']) {
        case "string":
            echo '<input type="text" class="form-control" id="parameter_value" name="parameter_value" value="'.$value.'" placeholder="参数值" style="width:300px; margin-right: 40px;"/>';
            break;
        case "bool":
        case "enum":
            echo '<select name="parameter_value" id="parameter_value" class="js-source-states" style="width:300px; margin-right: 40px;">';
            echo '<optgroup label="">';
            $options = explode(",", $parameter['options']);
            foreach ($options as $option) {
                if (trim($option) == $value) {
                    echo "<option value='" . trim($option) . "' selected='selected'>" . trim($option) . "</option>";
                } else {
                    echo "<option value='" . trim($option) . "'>" . trim($option) . "</option>";
                }
            }
            echo '</optgroup>';
            break;
        default:
            break;
    }

}
?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-5">
                                <button id="create_worker_btn" class="btn btn-success" type="button">保存</button>
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
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
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

    $('#create_worker_btn').click(function() {
        $.ajax({
            type: "POST",
            url: "/clientpackage/config-save",
            data:$('#edit_packageconfig_form').serialize(),
            dataType: "json",
            success: function(json) {
                if (json.status == 10000) {
                    swal({
                        title: "编辑配置信息成功！",
                        type: "success",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },function(){
                        window.location.href="/clientpackage/config-list";
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
    });
    
});
</script>
