<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                版本详情
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-md-6">
            <div class="font-bold m-b-sm">
                版本详情
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <form id="version_detail_form">
                            <input type="hidden" name="version_id" value="<?= $versionId; ?>" />
                            <table class="table table-hover table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">版本号</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['id']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">发行地区</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $platformInfo['region']['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">平台</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $platformInfo['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">升级序列</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['upgradePath']['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">创建人</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['create_user']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">创建时间</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['create_time']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3 text-center">
                                            <label class="control-label">修改日志</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <div class="panel-body">
                                                    <textarea name="changelog" placeholder="change log..." style="border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid; border-top: 0px solid; resize: none;" class="form-control" cols="100" rows="3"><?= $versionInfo['change_log']; ?></textarea>
                                                </div>
                                            </small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="input-group col-sm-12">
                                <button type="button" id="save_btn" name="save_btn" class="btn w-xs btn-success" onclick="javascript:changeLog();" style="position: relative; left: 40%;">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="font-bold m-b-sm">
                游戏模块版本号
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <tbody>
                                <?php foreach($moduleTags as $tag){ ?>
                                <tr>
                                    <td class="col-md-4 text-center">
                                        <label class="control-label"><?= $tag['description']; ?></label>
                                    </td>
                                    <td class="issue-info">
                                        <small>
                                            <?= $tag['tag']; ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-md-3 col-md-offset-3">
                    <a href="/task/publish?version_id=<?= $versionId; ?>" class="btn w-xs btn-success" style="margin-left: 170px; margin-top: -10px;">发布版本</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<script type="text/javascript">
    function changeLog()
    {
        $.ajax({
            url: '/version/modify',
            type: 'post',
            data: $('#version_detail_form').serialize(),
            dataType: 'json',
            success: function(response){
                if(response.data.result === 'success')
                {
                    swal({
                        title: response.data.msg,
                        text: "",
                        type: "success",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    });
                }
                else
                {
                    swal({
                        title: response.data.msg,
                        text: "",
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