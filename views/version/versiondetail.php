<?php
use yii\helpers\Html;
?>
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
                        <form id="version_detail_form" method="post" action="/version/modify">
                            <input type="hidden" name="version_id" value="<?= $versionId; ?>" />
                            <table class="table table-hover table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">版本号</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['id']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">发行区域</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $platformInfo['region']['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">平台</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $platformInfo['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">升级序列</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['upgradePath']['name']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">创建人</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['create_user']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
                                            <label class="control-label">创建时间</label>
                                        </td>
                                        <td class="issue-info">
                                            <small>
                                                <?= $versionInfo['create_time']; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2 text-center">
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
                                    <td class="col-md-2 text-center">
                                        <label class="control-label"><?= ucwords($tag['name']); ?></label>
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
                    <button class="btn w-xs btn-success" type="button" style="margin-left: 160px;" onclick="javascript: $('#version_detail_form').submit();">发布版本</button>
                </div>
            </div>
        </div>
    </div>
</div>