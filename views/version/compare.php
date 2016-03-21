<?php
/**
* compare.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2016 www.playcrab.com
* 
* Changelog:
* 2016-02-22 - created
* 
*/
use yii\helpers\Html;
?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                版本对比
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
    	<div class="hpanel">
    		<div class="panel-body">
    			<form class="form-inline" role="form" id="compare_form" name="compare_form">
    				<div class="form-group col-lg-4">
    					<label class="control-label">旧版本号：</label>
    					<input type="text" name="old_version_id" class="form-control" placeholder="旧版本号" value="<?php if (!empty($old_version_id) { echo $old_version_id;}?>" required>
    				</div>
    				<div class="form-group col-lg-4">
    					<label class="control-label">新版本号：</label>
    					<input type="text" name="new_version_id" class="form-control" placeholder="新版本号" value="<?php if (!empty($new_version_id) { echo $new_version_id;}?>" required>
    				</div>
    				<div class="form-group col-lg-4">
    					<button class="btn w-xs btn-warning" type="submit">对比版本</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<script>
    $(function(){
        $("#compare_form").validate({
            rules: {
                old_version_id: {
                    required: true,
                    number: true
                },
                new_version_id: {
                    required: true,
                    number: true
                }
            },
            messages: {
                old_version_id: {
                    required: "请填写旧版本号",
                    number: "请填写正确格式的版本号"
                },
                new_version_id: {
                    required: "请填写新版本号",
                    number: "请填写正确格式的版本号"
                }
            }
        });
    });
</script>
