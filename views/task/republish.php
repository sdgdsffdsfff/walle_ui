<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                发布任务确认
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
  <form method="post" class="form-horizontal" action="/task/republish">
    <div class="content">
      <div class="row">
      <div class="hpanel">
        <ul class="nav nav-tabs">
                <li class="active"><a aria-expanded="true" data-toggle="tab" href="components.html#tab-3"><h6>任务参数</h6></a></li>
         </ul>
        <div class="tab-content">
          <div id="tab-3" class="tab-pane active">
                 <div class="panel-body">
                 <div class="table-responsive">
                        <table class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
                            <thead>
                            <tr>
                                <th>类型</th>
                                <th>参数名称</th>
                                <th>参数取值</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>任务参数</td>
                                <td>发布位置</td>
                                <td>appstoreonline</td>
                            </tr>
                            <tr>
                                <td>任务参数</td>
                                <td>服务器更新包</td>
                                <td>                                   
                                     <input id="upload_server_update_package" type="checkbox" name="target_tasks" checked value="upload_server_update_package" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>任务参数</td>
                                <td>客户端更新包</td>
                                <td>
                                    90;94;95;101                                   
                                </td>
                            </tr>
                            <tr>
                                <td>任务参数</td>
                                <td>客户端安装包</td>
                                <td>
                                    tencent.online.ipa<br/>
                                    tentcent.test.ipa<br/>tencent.online.ipa<br/>tentcent.test.ipa<br/>
                                </td>
                            </tr>
                            <tr>
                                <td>dynamic_config</td>
                                <td>日志级别</td>
                                <td>DEBUG</td>
                            </tr>
                            <tr>
                                <td>dynamic_config</td>
                                <td>打包机</td>
                                <td>deploy1.walle.playcrab-inc.com</td>
                            </tr>
                            <tr>
                                <td>deployment_config</td>
                                <td>部署位置管理节点主机名</td>
                                <td>admin.kof.qq.com</td>
                            </tr>
                            <tr>
                                <td>deployment_config</td>
                                <td>CDN下载地址前缀</td>
                                <td>http://asset.playcrab.com/kof/</td>
                            </tr>
                            <tr>
                                <td>region_config</td>
                                <td>语言</td>
                                <td>ko_KR</td>
                            </tr>
                            <tr>
                                <td>region_config</td>
                                <td>美术资源源代码路径</td>
                                <td>/data/work/walle/kof/asset.ko_KR/</td>
                            </tr>
                            <tr>
                                <td>platform_config</td>
                                <td>客户端检查版本更新的API地址</td>
                                <td>http://appstore.kof.playcrab.com/vms/index.php</td>
                            </tr>
                            <tr>
                                <td>upgrade_path_config</td>
                                <td>手机操作系统</td>
                                <td>ios</td>
                            </tr>
                            <tr>
                                <td>upgrade_path_config</td>
                                <td>TP规则文件</td>
                                <td>tp_rule.ios.yaml</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        </div>
                     </div>
                     </div>
                </div>
            </div>
        <div class="row">
        <div style="" class="col-lg-2">
            <button type="button" class="btn btn-warning btn-block" onclick="javascript:pre('<?php echo Url::toRoute(['task/publish','version_id'=>12]);?>')" >上一步</button>
        </div>
        <div style="" class="col-lg-8">
             <button id="create_job_btn" type="button" class="btn btn-success btn-block">创建任务</button>
        </div>
        </div>
     </div>
  </form>
</div>
 <?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
 
<script type="text/javascript">
 $(function(){
	 $('#create_job_btn').click(function(){
		 swal({
			    title: "发布任务确认",
			    text: "",
			    type: "warning",
			    showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    swal("创建", "发布任务成功", "success");
                } else {
                    swal("取消", "取消发布任务", "error");
                }
			});
     });
 });
 function chkall()
 {
     var val = $('#chk_all').prop('checked');
     if(val == true)
     {
         $('#version_div :checkbox').prop('checked', true);
     }
     if(val == false)
     {
         $('#version_div :checkbox').prop('checked', false);
     }
 }

 function checkUpdateClient()
 {
     var val = $('#create_client_update_package').prop('checked');
     if(val == true)
     {
     	 $("#div2").show();
     }
     if(val == false)
     {
    	 $("#div2").hide();
     }
 }
 function checkClient()
 {
     var val = $('#create_client_package').prop('checked');
     if(val == true)
     {
    	 $("#div4").show();
     }
     if(val == false)
     {
    	 $("#div4").hide();
     }
 }
 function pre(url)
 {
	 window.location.href=url;
 }

 </script>
