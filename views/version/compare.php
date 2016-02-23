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
                发布任务列表
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
    					<input type="text" name="old_version_id" class="form-control" placeholder="旧版本号" value="<?php echo $old_version_id;?>" required>
    				</div>
    				<div class="form-group col-lg-4">
    					<label class="control-label">新版本号：</label>
    					<input type="text" name="new_version_id" class="form-control" placeholder="新版本号" value="<?php echo $new_version_id;?>" required>
    				</div>
    				<div class="form-group col-lg-4">
    					<button class="btn w-xs btn-warning" type="submit">对比版本</button>
    				</div>
    			</form>
    		</div>
    	</div>

    	<div class="hpanel">
    		<div class="panel-heading hbuilt">
    			版本对比详情
    		</div>
    		<div class="panel-body" >
    			<div class="table-responsive">
    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>参数</th>
    							<th>源版本</th>
    							<th>目标版本</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>版本号</td>
    							<td><a style='text-decoration:underline' href="">123</a></td>
    							<td><a style='text-decoration:underline' href="">456</a></td>
    						</tr>
    						<tr>
    							<td>发行地区</td>
    							<td>大陆发行</td>
    							<td>大陆发行</td>
    						</tr>
    						<tr>
    							<td>部署位置</td>
    							<td>appstoreonline</td>
    							<td>appstoreonline</td>
    						</tr>
    						<tr>
    							<td>升级序列</td>
    							<td>ios511</td>
    							<td>ios511</td>
    						</tr>
    						<tr>
    							<td>frontend_tag</td>
    							<td>master.150306.01</td>
    							<td>master.150306.02</td>
    						</tr>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid #6a6c6f;" />

    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>客户端更新包</th>
    							<th>大小</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab-inc.com/walle/package/icx/client_update_package/123456.7z</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab-inc.com/walle/package/icx/client_update_package/123456.7z</a></td>
    							<td>1024KB</td>
    						</tr>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid #6a6c6f;" />

    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>类型</th>
    							<th>改动文件数量</th>
    							<th>改动文件大小</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>all</td>
    							<td>3437</td>
    							<td>6032.2KB</td>
    						</tr>
    						<tr>
    							<td>script</td>
    							<td>3437</td>
    							<td>6032.2KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>3437</td>
    							<td>6032.2KB</td>
    						</tr>
    						<tr>
    							<td>config</td>
    							<td>3437</td>
    							<td>6032.2KB</td>
    						</tr>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid #6a6c6f;" />

                    <div style="height: 200px; overflow-y: scroll; overflow-x: hidden;">
    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>类型</th>
    							<th>改动文件名称</th>
    							<th>文件URL</th>
    							<th>文件大小</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    						<tr>
    							<td>asset</td>
    							<td>xxxx.plist</td>
    							<td><a style='text-decoration:underline' href="">http://rc.walle.playcrab.com/dsxadfdfsdafd.plist</a></td>
    							<td>1024KB</td>
    						</tr>
    					</tbody>
    				</table>
    				</div>
    			</div>
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
