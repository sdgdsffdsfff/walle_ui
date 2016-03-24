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
    					<input type="text" name="old_version_id" class="form-control" placeholder="旧版本号" value="<?php if(!empty($oldVersionInfo['id'])) {echo $oldVersionInfo['id'];}?>" required>
    				</div>
    				<div class="form-group col-lg-4">
    					<label class="control-label">新版本号：</label>
    					<input type="text" name="new_version_id" class="form-control" placeholder="新版本号" value="<?php if(!empty($newVersionInfo['id'])) {echo $newVersionInfo['id'];}?>" required>
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
    							<th>旧版本</th>
    							<th>新版本</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>版本号</td>
                                <td><a style='text-decoration:underline' href="version-detail?version_id=<?php echo $oldVersionInfo['id'];?>" target="black"><?php echo $oldVersionInfo['id'];?></a></td>
                                <td><a style='text-decoration:underline' href="version-detail?version_id=<?php echo $newVersionInfo['id'];?>" target="black"><?php echo $newVersionInfo['id'];?></a></td>
    						</tr>
    						<tr>
    							<td>发行地区</td>
                                <td><?php echo $oldVersionInfo['region']?></td>
                                <td><?php echo $newVersionInfo['region']?></td>
    						</tr>
    						<tr>
    							<td>平台</td>
                                <td><?php echo $oldVersionInfo['platform']?></td>
                                <td><?php echo $newVersionInfo['platform']?></td>
    						</tr>
    						<tr>
    							<td>部署位置</td>
<?php
function dealDeployment($deployment) {
    $old_deployment = "";
    $tmp = "";
    foreach ($deployment as $value) {
        $old_deployment .= $tmp.$value;
        $tmp = ", ";
    }
    return $old_deployment;
}
$old_deployment = dealDeployment($oldVersionInfo['deployment']);
$new_deployment = dealDeployment($newVersionInfo['deployment']);
echo "<td>$old_deployment</td>";
echo "<td>$new_deployment</td>";
?>
    						</tr>
    						<tr>
    							<td>升级序列</td>
                                <td><?php echo $oldVersionInfo['upgrade_path'];?></td>
                                <td><?php echo $newVersionInfo['upgrade_path'];?></td>
    						</tr>
<?php
if (!empty($oldVersionInfo['module']) && !empty($newVersionInfo['module'])) {
    foreach ($oldVersionInfo['module'] as $key => $value) {
        echo "<tr>";
        echo "<td>$key</td>";
        echo "<td>$value</td>";
        echo "<td>".$newVersionInfo['module'][$key]."</td>";
        echo "</tr>";
    }
}
?>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid orange;" />

    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>客户端更新包</th>
    							<th>大小(KB)</th>
    						</tr>
    					</thead>
    					<tbody>
<?php
if (!empty($clientUpdatePackageList)) {
    foreach ($clientUpdatePackageList as $clientUpdatePackage) {
        echo "<tr>";
        echo "<td><a style='text-decoration:underline' href='".$clientUpdatePackage['url']."' target='black'>".$clientUpdatePackage['url']."</a></td>";
        echo "<td>".$clientUpdatePackage['size']."</td>";
        echo "</tr>";
    }
}
?>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid orange;" />

    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>类型</th>
    							<th>改动文件数量</th>
    							<th>改动文件大小(KB)</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>all</td>
                                <td><?php echo $totalNum;?></td>
                                <td><?php echo $totalSize;?></td>
    						</tr>
<?php
if (!empty($updateStatistics)) {
    foreach ($updateStatistics as $type => $statistics) {
        echo "<tr>";
        echo "<td>$type</td>";
        echo "<td>".$statistics['num']."</td>";
        echo "<td>".$statistics['size']."</td>";
        echo "</tr>";
    }
}
?>
    					</tbody>
    				</table>

    				<hr style="height:1px;border:none;border-top:1px solid orange;" />

                    <div style="height: 200px; overflow-y: scroll; overflow-x: hidden;">
    				<table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
    					<thead>
    						<tr>
    							<th>类型</th>
    							<th>改动文件名称</th>
    							<th>文件URL</th>
    							<th>文件大小(KB)</th>
    						</tr>
    					</thead>
    					<tbody>
<?php
if (!empty($updateFileList)) {
    foreach ($updateFileList as $type => $fileList) {
        foreach ($fileList as $file) {
            echo "<tr>";
            echo "<td>$type</td>";
            echo "<td>".$file['filename']."</td>";
            echo "<td><a style='text-decoration:underline' href='".$file['url']."' target='black'>".$file['url']."</a></td>";
            echo "<td>".number_format($file['size']/1024, 2, '.', ',')."</td>";
            echo "</tr>";
        }
    }
}
?>
    					</tbody>
    				</table>
    				</div>
    			</div>
    		</div>
    	</div>



    </div>
</div>

<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<script type="text/javascript">
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
