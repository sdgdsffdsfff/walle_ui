<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                编辑升级序列配置
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
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="control-label">升级序列：</label>
                                        </td>
                                        <td>                                               
                                            <select name="region_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                                <option value="">请选择升级序列</option>
                                                <option value="1">ios</option>
                                                <option value="2">android</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="control-label">参数：</label>
                                        </td>
                                        <td>
                                            <select name="parameter_id" class="js-source-states" style="width:300px; margin-right: 40px;">
                                                <option value="">请选择参数</option>
                                                <option value="1">haha</option>
                                                <option value="2">gege</option>
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
