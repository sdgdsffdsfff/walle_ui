<?php
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
                新增升级序列配置
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
                    <form id="create_upgradepathconfig_form" method="get" class="form-horizontal">
                        <input type="hidden" id="parameter_type" name="parameter_type" value="" />
                        <div class="table-responsive">
                            <table id="create_upgradepathconfig_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>字段</th>
                                        <th>取值</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 50%;">
                                            <label class="control-label">升级序列：</label>
                                        </td>
                                        <td>
                                            <select id="sel_upgradepath" name="sel_upgradepath" class="js-source-states" style="width:300px; margin-right: 40px;">
                                                <option value="">请选择升级序列</option>
                                                <?php if($upgradePathList){ ?>
                                                    <?php foreach($upgradePathList as $value){ ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;">
                                            <label class="control-label">参数：</label>
                                        </td>
                                        <td>
                                            <select id="sel_parameter" name="sel_parameter" class="js-source-states" style="width:300px; margin-right: 40px;">
                                                <option value="">请选择参数</option>
                                                <?php if($parameters){ ?>
                                                    <?php foreach($parameters as $value){ ?>
                                                    <option value="<?= $value['id']; ?>" valType="<?= $value['value_type']; ?>" optVal="<?= $value['options']; ?>"><?= $value['description']; ?>(<?= $value['name']; ?>)</option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;">
                                            <label class="control-label">参数值：</label>
                                        </td>
                                        <td>     
                                            <input type="text" class="form-control" id="parameter_value" name="parameter_value" placeholder="参数值" style="width:300px; margin-right: 40px;" />
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
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/generalElement.js'); ?>
<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
    /*表单验证*/
    $('#create_upgradepathconfig_form').validate({
        ignore: '.ignore',
        rules: {
            sel_upgradepath: {
                required: true
            },
            sel_parameter: {
                required: true
            }
        },
        messages: {
            sel_upgradepath: {
                required: '请选择升级序列'
            },
            sel_parameter: {
                required: '请选择参数'
            }
        },
        submitHandler: function(form){
            submitForm();
        }
    });
    $("#sel_upgradepath").change(function(){
        $(this).valid();
    });
    $("#sel_parameter").change(function(){
        $(this).valid();
        //动态生成select和input
        generalElement('create_upgradepathconfig_table', this);
    });
    
    function submitForm()
    {
        $.ajax({
            url: '/upgradepath/config-create',
            type: 'post',
            data: $('#create_upgradepathconfig_form').serialize(),
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
                    },function(){
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
    
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown"
    };
});
</script>
