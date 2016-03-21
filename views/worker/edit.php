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
                编辑打包机配置
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
                        <form id="create_worker_form" method="post" class="form-horizontal">
                            <?php if($worker){ ?>
                            <input type="hidden" id="workerId" name="workerId" value="<?= $worker['id']; ?>" />
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
                                                <label class="control-label">主机名</label>
                                            </td>
                                            <td>                                               
                                                <input type="text" class="form-control" id="workerName" name="workerName" placeholder="hostname" <?php if($worker){ ?>value="<?= $worker['hostname']; ?>" readonly<?php } ?> />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="control-label">是否启用</label>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="i-checks checkbox" id="workerDisable" name="workerDisable" <?php if($worker && $worker['disable'] == 0){ ?>checked="checked"<?php } ?> />
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
</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<script type="text/javascript">
    $(function () {
        $(".js-source-states").select2();
        
        /*表单验证*/
        //添加验证规则,name值只能是英文,数字,下划线组成,不能有空格,只能以英文字母开头
        $('#create_worker_form').validate({
            rules: {
                workerName: {
                    required: true
                }
            },
            messages: {
                workerName: {
                    required: '请输入主机名称'
                }
            },
            submitHandler: function(form){
                submitForm();
            }
        });
    });
    
    //提交表单
    function submitForm()
    {
        var url_str = '';
        if($('#workerId').val())
        {
            url_str = '/worker/edit';
        }
        else
        {
            url_str = '/worker/create';
        }
        
        $.ajax({
            url: url_str,
            type: 'post',
            data: $('#create_worker_form').serialize(),
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
</script>