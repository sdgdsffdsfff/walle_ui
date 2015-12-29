<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <h5>创建版本</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    当前版本
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">现有版本</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="现有版本" class="form-control" name="current_version" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">平台</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="平台" class="form-control" name="platform" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">升级序列</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="升级序列" class="form-control" name="upgrade_path" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Frontend</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="Frontend" class="form-control" name="frontend" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Backend</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Backend" class="form-control" name="backend" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Script</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Script" class="form-control" name="script" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Asset</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Asset" class="form-control" name="asset" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Config</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Config" class="form-control" name="config" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kakura Node</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Kakura Node" class="form-control" name="kakura_node" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kakura Chat</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Kakura Chat" class="form-control" name="kakura_chat" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Battle</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Battle" class="form-control" name="battle" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Global</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Global" class="form-control" name="global" disabled="" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    新版本
                </div>
                <div class="panel-body">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" style="margin-left: -47px;">新版本参数</label>
                            <div class="col-sm-9 text-left">
                                <button class="btn w-xs btn-info" type="button">导入版本信息</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">平台</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" name="platform" style="width: 100%">
                                    <optgroup label="请选择发行区域-平台">
                                        <option value="AK">大陆发行-appstore</option>
                                        <option value="HI">海外发行-appstore</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">升级序列</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" name="upgrade_path" style="width: 100%">
                                    <optgroup label="请选择升级序列">
                                        <option value="AK">1111</option>
                                        <option value="HI">2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Frontend</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" name="frontend" style="width: 100%">
                                    <optgroup label="请选择frontend">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Backend</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="backend" style="width: 100%">
                                    <optgroup label="请选择backend">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Script</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="script" style="width: 100%">
                                    <optgroup label="请选择script">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Asset</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="asset" style="width: 100%">
                                    <optgroup label="请选择asset">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                                <!--<input type="text" placeholder="Asset" class="form-control" name="asset" disabled="" />-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Config</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="config" style="width: 100%">
                                    <optgroup label="请选择config">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                                <!--<input type="text" placeholder="Config" class="form-control" name="config" disabled="" />-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kakura Node</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="kakura_node" style="width: 100%">
                                    <optgroup label="请选择kakura_node">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Kakura Chat</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="kakura_chat" style="width: 100%">
                                    <optgroup label="请选择kakura_chat">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Battle</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="battle" style="width: 100%">
                                    <optgroup label="请选择battle">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Global</label>
                            <div class="col-lg-10">
                                <select class="js-source-states" name="global" style="width: 100%">
                                    <optgroup label="请选择global">
                                        <option value="AK">master-1111</option>
                                        <option value="HI">master-2222</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="summernote2">
                                <p>change log...</p>
                            </div>
                        </div><br/>
                        <div class="form-group">
                            <div class="col-sm-10 text-center">
                                <button class="btn w-xs btn-success" type="button">创建版本</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<script type="text/javascript">
    $(function(){
        $(".js-source-states").select2();
    });
    
    $('.summernote2').summernote({
        airMode: true
    });
</script>