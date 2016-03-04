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
                    <form id="add_regionconfig_form" class="form-horizontal">
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
                                            <select name="region_id" id="region_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                            <optgroup label="">
                                            <option value="">请选择发行地区</option>
<?php
if (isset($regionList) && !empty($regionList)) {//新增配置，提供全部发行地区供选择
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
                                            <select name="parameter_id" id="parameter_id" class="js-source-states" style="width:300px; margin-right: 40px;" >
                                            <option value="">请选择配置参数</option>
<?php
if (isset($parameterList) && !empty($parameterList)) {
    foreach ($parameterList as $param) {
        echo "<option value='" . $param['id'] . "'>" . $param['description']."(".$param['name'].")" . "</option>";
    }
}
?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">参数值：</label>
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
<script type="text/javascript">

$(function() {
    $(".js-source-states").select2();
    $('#add_regionconfig_form').validate({
        ignore: '.ignore',
        rules: {
            region_id: {
                required: true,
            },
            parameter_id: {
                required: true,
            }
        },
        messages: {
            region_id: {
                required: '请选择发行地区'
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
        var param_id = $(this).find("option:selected").val();
        $(this).valid();
        $('#parameter_value').rules("remove");
        $('#parameter_value').removeClass("error");
        $('#parameter_value').next().remove("label");
        changeInputType(param_id);
    });


    $("#region_id").change(function(){
        $(this).valid();
    });
    $("#parameter_value").change(function(){
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
            url: "/region/config-save",
            data:$('#add_regionconfig_form').serialize(),
            dataType: "json",
            success: function (json) {
                if (json.status == 10000) {
                    toastr.success("新增配置信息成功！");
                    window.location.href="/region/config-list";
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

//封装jquery validate 表单校验，根据parameter_type做不同的校验规则,返回validate对象
function check(parameter_type) {

    alert(parameter_type);
    if (parameter_type == 'string') {
        alert("string");
     return $('#add_regionconfig_form').validate({
            ignore: '.ignore',
            rules: {
                region_id: {
                    required: true,
                },
                parameter_id: {
                    required: true,
                }
            },
            messages: {
                region_id: {
                    required: '请选择发行地区'
                },
                parameter_id: {
                    required: '请选择配置参数'
                }
            },
            submitHandler: function(){}
        
        });
    
    } else {
        alert("bool enum");
     return $('#add_regionconfig_form').validate({
            ignore: '.ignore',
            rules: {
                region_id: {
                    required: true,
                },
                parameter_id: {
                    required: true,
                },
                parameter_value: {
                    required: true,
                }
            },
            messages: {
                region_id: {
                    required: '请选择发行地区'
                },
                parameter_id: {
                    required: '请选择配置参数'
                },
                parameter_value: {
                    required: '请选择参数值'
                }
            },
            submitHandler: function(){}
        
        });

    }
}

//动态更改参数值页面输入格式
function changeInputType(parameter_id) {
    //ajax 后台获取选择的参数类型，更改表单校验规则, js动态绘制参数值输入方式
    $.ajax({
        type: "POST",
        url: "/region/getparaminfo",
        data:"parameter_id="+parameter_id,
        dataType: "json",
        success: function (json) {
            if (json.status == 10000) {
                //js 修改 parameter_value的输入格式
                var field = document.getElementById("parameter_value_field");
                $('#parameter_value_field').empty();
                if (json.data.value_type == "bool" || json.data.value_type == "enum") {
                    var sele = document.createElement("select");
                    sele.setAttribute("name", "parameter_value");
                    sele.setAttribute("id", "parameter_value");
                    //sele.setAttribute("class", "js-source-states");
                    sele.setAttribute("style", "width:300px; margin-right: 40px;");

                    field.appendChild(sele);
                    $('#parameter_value').html("<option value='' selected='selected'>请选择参数值</option>").select2();
                
                    var arr = new Array();
                    arr = json.data.options.split(",");
                    for (var index in arr) {
                        value = $.trim(arr[index]);
                        var option = document.createElement("option");
                        //var text = document.createTextNode(arr[index]);
                        option.setAttribute("value", value);
                        option.text = value;
                        sele.appendChild(option);
                    } 
                    //添加校验规则
                    $('#parameter_value').rules("remove");
                    $('#parameter_value').rules("add",{required: true, messages: { required: "请选择参数值"}});
                } else {
                    var input = document.createElement("input");
                    input.setAttribute("name", "parameter_value");
                    input.setAttribute("id", "parameter_value");
                    input.setAttribute("style", "width:300px; margin-right: 40px;");
                    input.setAttribute("placeholder", "参数值");
                    input.setAttribute("class", "form-control");
                    field.appendChild(input);
                } 
            } else {
                //获取value_type 失败
                alert("请选择参数");

            }
        }

    });
}
</script>
