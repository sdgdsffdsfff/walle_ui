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
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="hpanel">
                <div class="panel-heading">
                    待对比任务列表
                </div>
                <div class="panel-body">
                    <form id="task_compare_form" method="post" class="form-horizontal" action="/task/compare-detail">
                        <input type="hidden" id="compare_jobIds" name="compare_jobIds" value="" />
                        <div>
                            <table id="task_compare_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>任务ID</th>
                                        <th>版本号</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group" style="margin-top: -20px; color: red;">
                            <span class="col-md-8" style="margin-left: 5px;">(注: 最多可添加5个)</span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" style="margin-left: -10px;">任务ID: </label>
                            <div class="col-sm-4" style="margin-left: -16px;">
                                <input type="text" id="job_id" name="job_id" placeholder="任务ID" class="form-control" />
                            </div>
                            <span class="input-group-btn" style="right: -16px;">
                                <input type="button" id="add_task_btn" name="add_task_btn" class="btn w-xs btn-success" value="添加至待对比列表" />
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4">
                    <button type="submit" id="task_compare_btn" name="task_compare_btn" class="btn w-xs btn-success" style="margin-left: 126px;">任务对比</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        var t = $('#task_compare_table').DataTable({
            'language': { "emptyTable": '暂无对比数据' },
            "paging":   false,
            "ordering": false,
            "info":     false,
            "bFilter":  false
        });
        var counter = 1;

        $('#add_task_btn').on('click', function(){
            if(counter > 5)
            {
                swal({
                    title: "最多添加5条任务!",
                    type: "error",
                    showCancelButton: false, //是否显示'取消'按钮
                    confirmButtonColor: "#e74c3c",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                });
            }
            else
            {
                var job_id = $('#job_id').val();
                //根据任务id获取相应的信息
                $.ajax({
                    url: '/task/compare',
                    type: 'post',
                    data: 'job_id='+job_id,
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 10000)
                        {
                            var compare_ids = $('#compare_jobIds').val();
                            var search_str = new RegExp(job_id);
                            if(search_str.test(compare_ids))
                            {
                                swal({
                                    title: '该任务id已存在,请更换任务id!',
                                    type: "error",
                                    showCancelButton: false, //是否显示'取消'按钮
                                    confirmButtonColor: "#e74c3c",
                                    confirmButtonText: "确认",
                                    closeOnConfirm: false
                                });
                            }
                            else
                            {
                                t.row.add( [
                                    response.data.id,
                                    response.data.version_id
                                ] ).draw();

                                counter++;

                                compare_ids += job_id+',';
                                $('#compare_jobIds').val(compare_ids);
                            }
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
        });
        
        $('#task_compare_btn').on('click', function(){
            var columns = $('#task_compare_table tbody').children(':first').find('td').length;
            var rows = $('#task_compare_table tbody').children().length;
            if(columns <= 1)
            {
                swal({
                    title: "请添加对比任务!",
                    type: "error",
                    showCancelButton: false, //是否显示'取消'按钮
                    confirmButtonColor: "#e74c3c",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                });
                
                return false;
            }
            else if(rows < 2)
            {
                swal({
                    title: "至少需要2个对比任务!",
                    type: "error",
                    showCancelButton: false, //是否显示'取消'按钮
                    confirmButtonColor: "#e74c3c",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                });
                
                return false;
            }
            else
            {
                $('#task_compare_form').submit();
            }
        });
    });
</script>