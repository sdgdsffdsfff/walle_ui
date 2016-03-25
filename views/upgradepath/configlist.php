<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/toastr/build/toastr.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<?= Html::cssFile('@web/static/plugins/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                升级序列配置
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4">
                    <a href="/upgradepath/config-create" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>
                </div>
            </div>
        </div>
    </div>
    
	<div class="row">
        <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
            <table id="upgrade_path_table" cellpadding="1" cellspacing="1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>升级序列</th>
                        <th>参数</th>
                        <th>参数值</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <?php if($list && $flag){ ?>
                <tbody>
                    <?php foreach($list as $config){ ?>
                    <tr>
                        <td><?= $config['upgradePath']['name']; ?></td>
                        <td><?= $config['parameter']['description'].'（'.$config['parameter']['name'].'）'; ?></td>
                        <td><?= $config['value']; ?></td>
                        <td align="center">
                            <a href="/upgradepath/config-edit?param_id=<?= $config['parameter_id']; ?>&upgradepath_id=<?= $config['upgrade_path_id']; ?>" class='btn btn-info'>编辑</a>&nbsp;
                            <button class='btn btn-danger' onclick='javascript:deleteUpgradeConfig(<?= $config['parameter_id']; ?>, <?= $config['upgrade_path_id']; ?>);'>删除</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<script type="text/javascript">
$(function() {
    $('#upgrade_path_table').DataTable({
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [3] }],
        "paging":   false,
        "info":     false,
        "dom": '<"clear">', //通过dom属性去掉search文本框
        initComplete: function () {
            $('#upgrade_path_table thead').append('<tr></tr>');

            var api = this.api();
            api.columns().indexes().flatten().each( function ( i ) {
                if(i < 3)
                {
                    $('#upgrade_path_table thead').find('tr:last').append('<th></th>');
                    var column = api.column( i );
                    //console.log(column.header());
                    var select = $('<select class="js-source-states" style="margin-right: 40px;"><option value="">全部</option></select>')
                        .appendTo( $('#upgrade_path_table thead').find('tr:last').find('th').eq(i) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                    column.data().unique().sort().each( function ( d, j ) {
                        if('<?= $upgrade_path_name; ?>' && (d == '<?= $upgrade_path_name; ?>'))
                        {
                            select.append( '<option value="'+d+'" selected>'+d+'</option>' );
                            column
                                .search( "<?= $upgrade_path_name; ?>" ? '^'+"<?= $upgrade_path_name; ?>"+'$' : '', true, false )
                                .draw();
                        }
                        else
                        {
                            if(d != '')
                            {
                                select.append( '<option value="'+d+'">'+d+'</option>' );
                            }
                        }
                    } );
                }
            } );
        }
    });
    
    //select2
    $(".js-source-states").select2({ 
        width: '100%' //设定select框宽度
    });

    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown"
    };
});

function deleteUpgradeConfig(parameter_id, upgradePath_id) 
{
	swal({
        title: "确定要删除该配置信息吗?",
        type: "warning",
        showCancelButton: true, //是否显示'取消'按钮
        confirmButtonColor: "#e74c3c",
        confirmButtonText: "确认",
        cancelButtonText: "取消",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm){
        if(isConfirm) 
        {
            submitForm(parameter_id, upgradePath_id);
        } 
        else 
        {
            //swal("取消", "取消发布任务", "error");
        }
    });
}

function submitForm(parameter_id, upgradePath_id)
{
    $.ajax({
        url: '/upgradepath/config-delete',
        type: 'post',
        data: 'parameter_id='+parameter_id+'&upgradePath_id='+upgradePath_id,
        dataType: 'json',
        success: function(response){
            if(response.status == '40003')
            {
                swal({
                    title: "权限提示",
                    text: response.description,
                    type: "warning",
                    showCancelButton: false, //是否显示'取消'按钮
                    confirmButtonColor: "#e74c3c",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                });
            }
            if(response.status == '10000')
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
                    window.location.href = '/upgradepath/config-list';
                });
            }
            if(response.status == '99999')
            {
                swal({
                    text: response.description,
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