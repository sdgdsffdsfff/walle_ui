<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                编辑参数配置
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-10">
            <div class="hpanel">
                <div class="col-xs-5 col-md-4"></div>
                <div class="col-xs-5 col-md-7">
                    <div class="panel-body">
                        <form id="create_parameter_form" method="post" class="form-horizontal">
                            <?php if($parameter){ ?>
                            <input type="hidden" id="param_id" name="param_id" value="<?= $parameter['id']; ?>" />
                            <?php } ?>
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
                                                <label class="control-label">参数名称</label>
                                            </td>
                                            <td>                                               
                                                <input type="text" class="form-control" id="param_name" name="param_name" placeholder="name" <?php if($parameter){ ?>value="<?= $parameter['name']; ?>" readonly=""<?php } ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">参数类型</label>
                                            </td>
                                            <td>
                                                <select class="js-source-states" id="param_value_type" name="param_value_type" style="width: 100%">
                                                    <option value="">请选择值类型</option>
                                                    <option value="enum" <?php if($parameter && (strtolower($parameter['value_type']) == 'enum')){ ?>selected<?php } ?>>enum</option>
                                                    <option value="bool" <?php if($parameter && (strtolower($parameter['value_type']) == 'bool')){ ?>selected<?php } ?>>bool</option>
                                                    <option value="string" <?php if($parameter && (strtolower($parameter['value_type']) == 'string')){ ?>selected<?php } ?>>string</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">描述信息</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="param_description" name="param_description" placeholder="description" value="<?php if($parameter){ ?><?= $parameter['description']; ?><?php } ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">默认值</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="param_default_value" name="param_default_value" placeholder="default_value" value="<?php if($parameter){ ?><?= $parameter['default_value']; ?><?php } ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">是否启用</label>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="i-checks checkbox" id="param_disable" name="param_disable" <?php if($parameter && $parameter['disable'] == 0){ ?>checked="checked"<?php } ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">备选项</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="param_options" name="param_options" placeholder="options" value="<?php if($parameter){ ?><?= $parameter['options']; ?><?php } ?>" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-5">
                                    <button id="create_parameter_btn" class="btn btn-success" type="submit">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/stringCheck.js'); ?>
<script type="text/javascript">
    $(function () {
        $(".js-source-states").select2();
        
        /*表单验证*/
        //添加验证规则,name值只能是英文,数字,下划线组成,不能有空格,只能以英文字母开头
        $('#create_parameter_form').validate({
            ignore: '.ignore',
            rules: {
                param_name: {
                    required: true,
                    stringCheck: true
                },
                param_value_type: {
                    required: true
                },
                param_description: {
                    required: true
                },
                param_default_value: {
                    required: true
                }
            },
            messages: {
                param_name: {
                    required: '请输入参数英文名称',
                    stringCheck: '只能由英文字母,数字,下划线组成,以英文字母开头'
                },
                param_value_type: {
                    required: '请选择参数类型'
                },
                param_description: {
                    required: '请输入参数中文描述'
                },
                param_default_value: {
                    required: '请输入参数默认值'
                }
            },
            submitHandler: function(form){
                submitForm();
            }
        });
        $("#param_value_type").change(function(){
            $(this).valid();
            
            $("#param_options").rules("remove");  
            $('#param_options').removeClass('error');  //删除验证的error样式
            $('#param_options').next().remove('label');  //删除验证信息的label
            
            var sel_val = $(this).find("option:selected").val();
            if(sel_val == "enum" || sel_val == "bool")
            {
                $("#param_options").rules("remove");
                $("#param_options").rules("add", { required: true, messages: { required: "请输入备选值"} });
            }
        });
    });
    
    //提交表单
    function submitForm()
    {
        var url_str = '';
        if($('#param_id').val())
        {
            url_str = '/parameter/edit';
        }
        else
        {
            url_str = '/parameter/create';
        }
        
        $.ajax({
            url: url_str,
            type: 'post',
            data: $('#create_parameter_form').serialize(),
            dataType: 'json',
            success: function(response){
                if(response.status == 10000)
                {
                    swal({
                        title: response.description,
                        type: "success",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },
                    function(){
                        window.location.href = response.data.redirect_url;
                    });
                }
                else
                {
                    swal({
                        title: response.description,
                        type: "error",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    });
                }
            }
        });
    }
</script>