<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweetalert2.css'); ?>
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
                        <input type="text" id="job_id" name="job_id" class="form-control" placeholder="任务ID" value="<?= $job_id; ?>" required />
                        <?php if($flag){ ?>&nbsp;&nbsp;<span id="notice" style="color: red;">最多可以比较5个任务!</span><?php } ?>
                    </div>
                    <div class="form-group col-lg-4">
                        <button class="btn w-xs btn-warning" type="submit" id="add_task_btn" name="add_task_btn" style="margin-left: 170px;">添加对比任务</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4">
                    <button id="select_data_btn" class="btn w-xs btn-warning2" style="margin-left: 160px; margin-bottom:10px;">显示/隐藏相同项</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="hpanel horange">
            <div class="panel-body">
                <div class="table-responsive" style="height: 800px;">
                    <table id="job_table" class="table table-bordered table-striped" cellpadding="1" cellspacing="1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>类型</th>
                                <th>参数名称</th>
                                <?php if($jobConfigs){ ?>
                                    <?php for($i = 0;$i < count($jobConfigs); $i++){ ?>
                                <th>参数取值<a style="float: right; position: static;" onclick="javascript:removeCol('<?= $jobId_arr[$i] ?>');"><i class="fa fa-times"></i></a></th>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <th>参数取值</th>
                                <?php } ?>
                            </tr>
                            <?php if($jobConfigs){ ?>
                            <tr>
                                <th></th>
                                <th>任务ID</th>
                                <?php for($i = 0;$i < count($jobConfigs); $i++){ ?>
                                <th><?= $jobId_arr[$i] ?></th>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </thead>
                        <?php if($jobConfigs){ ?>
                        <tbody>
                            <?php foreach($fieldsConfig as $field){ ?>
                            <tr>
                                <td><?= $field['type']; ?></td>
                                <td><?= $field['name']; ?></td>
                                <?php foreach($jobConfigs as $key => $data){ ?>
                                    <?php if(isset($field['value'][$key]) && !empty($field['value'][$key])){ ?>
                                    <td><?= $field['value'][$key]; ?></td>
                                    <?php }else{ ?>
                                    <td></td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweetalert2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/tableHeadFixer.js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#job_table").tableHeadFixer({"left" : 2});
        
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
        
        $('#select_data_btn').bind('click', function(){
            var boolean;
            $("#job_table tbody tr").each(function(trindex, tritem){   //遍历每一行
                var txtVal = '';
                $(tritem).find('td:gt(1)').each(function(tdindex, tditem){
                    if(tdindex == 0)
                    {
                        txtVal = $.trim($(tditem).text());
                        return true;
                    }
                    return boolean = filterElement(txtVal, tdindex, tditem);
                });
                //console.log(trindex+'---->'+boolean);
                //隐藏相同行
                if(boolean)
                {
                    $(tritem).toggle();
                }
            });
        });
        
        <?php if($flag){ ?>
            $('#notice').fadeOut(6000);
        <?php } ?>
    });
    
    function filterElement(txtVal, tdindex, tditem)
    {
        if(txtVal != $.trim($(tditem).text()))
        {
            return false;
        }

        return true;
    }
    
    function removeCol(job_id)
    {
        //获取td索引位置
        var pos = '';
        $("#job_table tbody tr").eq(0).find('td').each(function(i){
            if(job_id == $.trim($(this).text()))
            {
                pos = i;
                return false;
            }
        });
        //console.log(pos);
        if((pos != '') && (/(^[0-9]\d*$)/.test(pos)))
        {
            //根据任务id获取相应的信息
            $.ajax({
                url: '/task/delete-job',
                type: 'post',
                data: 'job_id='+job_id,
                dataType: 'json',
                success: function(response){
                    if(response.status == 10000)
                    {
                        deleteOperate(pos);
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
        else
        {
            swal({
                title: '任务id不匹配,无法删除!',
                type: "error",
                showCancelButton: false, //是否显示'取消'按钮
                confirmButtonColor: "#e74c3c",
                confirmButtonText: "确认",
                closeOnConfirm: false
            });
        }
    }
    function deleteOperate(pos)
    {
        $("#job_table tbody tr").each(function(trindex, tritem){   //遍历每一行
            $(tritem).find('td').each(function(tdindex, tditem){   //遍历改行的td
                if(tdindex == pos)
                {
                    $(tditem).remove();
                }
            });
        });
//            $("#job_table thead tr").eq(0).find('th').each(function(j, item){   //遍历每一行
//                if(j == pos)
//                {
//                    $(item).remove();
//                }
//            });
        $("#job_table thead tr").each(function(trindex, tritem){   //遍历每一行
            $(tritem).find('th').each(function(thindex, thitem){   //遍历改行的td
                if(thindex == pos)
                {
                    $(thitem).remove();
                }
            });
        });
    }
</script>