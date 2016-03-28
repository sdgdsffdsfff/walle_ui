<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                发布任务对比
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
    	<div class="hpanel">
    		<div class="panel-body">
                <form class="form-inline" role="form" id="task_compare_form" method="post" action="/task/compare-detail">
    				<div class="form-group col-lg-8">
    					<label class="control-label">任务ID：</label>
    					<input type="text" id="job_id" name="job_id" class="form-control" placeholder="任务ID" required />
                    </div>
                    <div class="form-group col-lg-4">
                        <button class="btn w-xs btn-warning" type="submit" id="add_task_btn" name="add_task_btn" style="margin-left: 170px;">添加对比任务</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#task_compare_form").validate({
            rules: {
                job_id: {
                    required: true,
                    number: true
                }
            },
            messages: {
                job_id: {
                    required: "请输入任务ID",
                    number: "请输入正确格式的任务ID"
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });
        
//        function subForm()
//        {
//            var job_id = $('#job_id').val();
//            //根据任务id获取相应的信息
//            $.ajax({
//                url: '/task/compare',
//                type: 'post',
//                data: 'job_id='+job_id,
//                dataType: 'json',
//                success: function(response){
//                    if(response.status == 10000)
//                    {
//                        $('#task_compare_form').submit();
//                    }
//                    else
//                    {
//                        swal({
//                            title: response.description,
//                            type: "error",
//                            showCancelButton: false, //是否显示'取消'按钮
//                            confirmButtonColor: "#e74c3c",
//                            confirmButtonText: "确认",
//                            closeOnConfirm: false
//                        });
//                    }
//                }
//            });
//        }
    });
</script>