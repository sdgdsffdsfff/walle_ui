<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                创建版本
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    当前版本
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">现有版本</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" placeholder="现有版本" class="form-control" id="current_version" name="current_version" />
                                    <span class="input-group-btn">
                                        <input type="button" id="search_btn" name="search_btn" class="btn btn-warning" value="查询" onclick="javascript:getVersion();" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">平台</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="平台" class="form-control" id="platform" name="platform" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">升级序列</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="升级序列" class="form-control" id="upgrade_path" name="upgrade_path" disabled="" />
                            </div>
                        </div>
                        <?php foreach($module_list as $module){ ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= $module['description']; ?></label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="<?= ucwords($module['name']); ?>" class="form-control" id="<?= $module['name']; ?>" name="<?= $module['name']; ?>" disabled="" />
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    新版本
                </div>
                <div class="panel-body">
                    <form id="create_version_form" role="create_version_form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="margin-left: -47px;">新版本参数</label>
                            <div class="col-sm-9 text-left">
                                <button class="btn w-xs btn-info" id="import_btn" type="button">导入版本信息</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">平台</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" id="new_platform" name="new_platform" style="width: 100%">
                                    <option value="">请选择发行区域-平台</option>
                                    <?php foreach($platform_list as $platform){ ?>
                                    <option value="<?= $platform['id']; ?>"><?= $platform['region']['name']; ?> - <?= $platform['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">升级序列</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" id="new_upgrade_path" name="new_upgrade_path" style="width: 100%">
                                    <option value="">请选择升级序列</option>
                                    <?php foreach($upgradePath_list as $upgradePath){ ?>
                                    <option value="<?= $upgradePath['id']; ?>"><?= $upgradePath['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php foreach($module_list as $module){ ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= $module['description']; ?></label>
                            <div class="col-sm-10">
                                <?php if($module['repo_type'] == 'SVN'){ ?>
                                <input type="text" placeholder="<?= ucwords($module['name']); ?>" class="form-control" id="new_<?= $module['name']; ?>" name="new_<?= $module['name']; ?>" />
                                <?php }else{ ?>
                                <select class="js-source-states" id="new_<?= $module['name']; ?>" name="new_<?= $module['name']; ?>" style="width: 100%">
                                    <option value="">请选择<?= ucwords($module['name']); ?></option>
                                    <?php foreach($moduleAvailableTag_list as $module_id => $tags){ ?>
                                        <?php if($module_id == $module['id']){ ?>
                                            <?php foreach($tags as $val){ ?>
                                            <option value="<?= $val; ?>"><?= $val; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="panel-body">
                            <div class="col-sm-13">
                                <textarea name="changelog" placeholder="change log..." style="border-bottom: 0px solid; border-left: 0px solid; border-right: 0px solid; border-top: 0px solid; resize: none;" class="form-control" cols="100" rows="3"></textarea>
                            </div>
                        </div><br/>
                        <div class="form-group">
                            <div class="col-sm-10 text-center">
                                <button id="create_version_btn" class="btn w-xs btn-success" type="submit">创建版本</button>
                            </div>
                        </div>
                    </form>
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
        $('#create_version_form').validate({
            ignore: '.ignore',
            rules: {
                new_platform: {
                    required: true
                },
                new_upgrade_path: {
                    required: true
                },
                <?= $rules; ?>
            },
            messages: {
                new_platform: {
                    required: '请选择区域 - 平台'
                },
                new_upgrade_path: {
                    required: '请选择升级序列'
                },
                <?= $messages; ?>
            },
            submitHandler: function(form){
                //form.submit();
                popConfirm();
            }
        });
        $("#new_platform").change(function(){
            $(this).valid();  
        });
        $("#new_upgrade_path").change(function(){
            $(this).valid();  
        });
        <?= $changes; ?>     
    });

    //敲回车查询
    $('#current_version').keyup(function (event) {
        if (event.keyCode === 13)
        {
            getVersion();
        }
    });

    function getVersion()
    {
        $versionId = $('#current_version').val();
        if(!$versionId)
        {
            return false;
        }
        $.ajax({
            url: '/version/add-version',
            type: 'post',
            data: 'version_id='+$versionId,
            dataType: 'json',
            success: function(response){
                $('#platform').val(response.data.region_name + ' - ' + response.data.platform_name);
                $('#upgrade_path').val(response.data.upgrade_name);
                for(var i = 0; i < response.data.module_tags.length; i++)
                {
                    $('#' + response.data.module_tags[i].name).val(response.data.module_tags[i].tag);
                }
            }
        });
    }
    
    //导入版本信息
    $('#import_btn').bind('click', function(){
        $versionId = $('#current_version').val();
        if(!$versionId)
        {
            return false;
        }
        $.ajax({
            url: '/version/import-version',
            type: 'post',
            data: 'version_id='+$versionId,
            dataType: 'json',
            success: function(response){
                $('#new_platform').select2('val', response.data.platform_id);
                $('#new_upgrade_path').select2('val', response.data.upgrade_id);
                for(var i = 0; i < response.data.module_tags.length; i++)
                {
                    if(response.data.module_tags[i].module_type === 'SVN')
                    {
                        $('#new_' + response.data.module_tags[i].name).val(response.data.module_tags[i].tag);
                    }
                    else
                    {
                        $('#new_' + response.data.module_tags[i].name).select2('val', response.data.module_tags[i].tag);
                    }
                }
            }
        });
    });
    
    //弹出提交表单确认框
    function popConfirm()
    {
        swal({
            title: "创建版本确认",
            text: "确定要创建新版本吗?",
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
                submitForm();
            } 
            else 
            {
                //swal("取消", "取消发布任务", "error");
            }
        });
    }
    
    //提交表单
    function submitForm()
    {
        $.ajax({
            url: '/version/create-version',
            type: 'post',
            data: $('#create_version_form').serialize(),
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
                        closeOnConfirm: false,
                    });
                }
                if(response.data.msg == 'success')
                {
                    window.location.href="/version/version-detail?version_id="+response.data.version_id;
                }
                if(response.data.msg == 'fails')
                {
                    swal({
                        title: "创建版本结果",
                        text: "创建版本失败!",
                        type: "error",
                        showCancelButton: false, //是否显示'取消'按钮
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false,
                    });
                }
            }
        });
    }
</script>