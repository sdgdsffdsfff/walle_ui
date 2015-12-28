<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
 <?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>

'',
<div class="content animate-panel">
<div class="row">
    <div class="col-lg-6">
        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                选择发布位置和任务目标
            </div>
            <div class="panel-body no-padding">
                <div class="panel-body">
                   <form method="get" class="form-horizontal">
                        <div class="form-group"><label class="col-sm-2 control-label">发布位置</label>
                            <div class="col-sm-10">
                                <select class="js-source-states"  style="width: 100%">
                            <option value="Blue">Blue</option>
                            <option value="Red">Red</option>
                            <option value="Green">Green</option>
                            <option value="Maroon">Maroon</option>
                    </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Help text</label>
        
                            <div class="col-sm-10"><input type="text" class="form-control"> <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Password</label>
        
                            <div class="col-sm-10"><input type="password" class="form-control" name="password"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Placeholder</label>
        
                            <div class="col-sm-10"><input type="text" placeholder="placeholder" class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Disabled</label>
        
                            <div class="col-lg-10"><input type="text" disabled="" placeholder="Disabled input here..." class="form-control"></div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Static control</label>
        
                            <div class="col-lg-10"><p class="form-control-static">email@example.com</p></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button class="btn btn-default" type="submit">Cancel</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                        </div>
                    </form>
                  </div>
            </div>
            <div class="panel-footer">
                This is standard panel footer
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="hpanel">
            <div class="panel-heading hbuilt">
                <div class="panel-tools">
                    <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    <a class="closebox"><i class="fa fa-times"></i></a>
                </div>
                选择客户端更新包
            </div>
            <div class="alert alert-success">
                <i class="fa fa-bolt"></i> Adding action was successful
            </div>
            <div class="panel-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.Lorem
                    ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                </p>
            </div>
            <div class="panel-footer">
                This is standard panel footer
            </div>
        </div>
    </div>
</div>
</div>
 <?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<script type="text/javascript">
 $(function(){
	 $(".js-source-states").select2();  
 });
 </script>
