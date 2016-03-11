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
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>

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
                    <form id="add_packageconfig_form" class="form-horizontal">
                        <div class="table-responsive">
                            <table id="create_config_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>字段</th>
                                        <th>取值</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="control-label">安装包名称:</label>
                                        </td>
                                        <td>                                               
                                            <select name="package_id" id="package_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                            <optgroup label="">
                                            <option value="">请选择安装包</option>
<?php
if (isset($packageList) && !empty($packageList)) {//新增配置，提供全部发行地区供选择
    foreach ($packageList as $reg) {
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
                                            <label class="control-label">参数:</label>
                                        </td>
                                        <td>
                                            <select name="parameter_id" id="parameter_id" class="js-source-states" style="width:300px; margin-right: 40px;" >
                                            <option value="">请选择配置参数</option>
<?php
if (isset($parameterList) && !empty($parameterList)) {
    foreach ($parameterList as $param) {
        echo "<option value='" . $param['id'] . "' valType='".$param['value_type']."' optVal='".trim($param['options'])."'>" . $param['description']."(".$param['name'].")" . "</option>";
    }
}
?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">参数值:</label>
                                        </td>
                                        <td id="parameter_value_field">
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
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/generalElement.js'); ?>
<script type="text/javascript">

$(function() {
    $(".js-source-states").select2();
    $('#add_packageconfig_form').validate({
        ignore: '.ignore',
        rules: {
            package_id: {
                required: true,
            },
            parameter_id: {
                required: true,
            }
        },
        messages: {
            package_id: {
                required: '请选安装包'
            },
            parameter_id: {
                required: '请选择配置参数'
            }
        },
        submitHandler: function(form){
            submitForm();
        }
    });
    $('#parameter_id').change(function(){
        $(this).valid();
        generalElement('create_config_table', this);
    });


    $("#package_id").change(function(){
        $(this).valid();
    });
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown"
    };


    function submitForm() {
        $.ajax({
            type: "POST",
            url: "/package/config-save",
            data:$('#add_packageconfig_form').serialize(),
            dataType: "json",
            success: function (json) {
                if (json.status == 10000) {
                    swal({
                        title: "新增配置信息成功！",
                        type: "success",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },function(){
                        window.location.href="/package/config-list";
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
    }

});

</script>
