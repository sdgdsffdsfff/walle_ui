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
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>

<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                编辑动态参数配置
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
                        <form id="edit_dynamic_form" method="get" class="form-horizontal">
                            <div class="table-responsive">
                                <table id="create_dynamicparameter_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>字段</th>
                                            <th>取值</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
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
                                        	<td style="width: 20%;">
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
                                    <button id="save_config" class="btn btn-success" type="submit">保存</button>
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
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/generalElement.js'); ?>

<script type="text/javascript">
$(function() {
    $(".js-source-states").select2();
    /*表单验证*/
    $('#edit_dynamic_form').validate({
        ignore: '.ignore',
        rules: {
            sel_parameter: {
                required: true
            }
        },
        messages: {
            sel_parameter: {
                required: '请选择参数'
            }
        },
        submitHandler: function(form){
            submitForm();
        }
    });
    $("#sel_parameter").change(function(){
        $(this).valid();
        //动态生成select和input
        generalElement('create_dynamicparameter_table', this);
    });
    
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
