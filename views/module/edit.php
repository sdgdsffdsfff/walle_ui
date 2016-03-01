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
                编辑业务模块配置
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
                        <form id="create_module_form" method="get" class="form-horizontal">
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
                                                <label class="control-label">模块名称</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="module_name" name="module_name" placeholder="name" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">描述信息</label>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="module_description" name="module_description" placeholder="description" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">是否启用</label>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="i-checks checkbox" id="module_default_value" name="module_default_value" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">仓库类型</label>
                                            </td>
                                            <td>
                                                <select class="js-source-states" id="module_options" name="module_options" style="width: 100%">
                                                    <option value="">请选择仓库类型</option>
                                                    <option value="svn">SVN</option>
                                                    <option value="git">GIT</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-5">
                                    <button id="create_module_btn" class="btn btn-success" type="submit">保存</button>
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
        $('#create_module_form').validate({
            ignore: '.ignore',
            rules: {
                module_name: {
                    required: true,
                    stringCheck: true
                },
                module_description: {
                    required: true
                },
                module_options: {
                    required: true
                }
            },
            messages: {
                module_name: {
                    required: '请输入模块英文名称',
                    stringCheck: '只能由英文字母,数字,下划线组成,以英文字母开头'
                },
                module_description: {
                    required: '请输入模块中文描述'
                },
                module_options: {
                    required: '请选择仓库类型'
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });
    });
</script>