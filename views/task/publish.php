<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<div class="normalheader transition small-header">
	<div class="hpanel">
		<div class="panel-body">
			<h5 class="font-light m-b-xs">发布任务</h5>
		</div>
	</div>
</div>
<div class="content animate-panel">
	<form id="publish_form" method="post" class="form-horizontal" action="/task/republish">
		<input name="_csrf" type="hidden" id="_csrf"
			value="<?= Yii::$app->request->csrfToken ?>">
		<div class="content">
			<div class="row">
				<div class="col-lg-6">
					<div class="hpanel hgreen">
						<div class="panel-heading hbuilt">
							<div class="panel-tools">
								<!--                     <a class="showhide"><i class="fa fa-chevron-up"></i></a> -->
								<!--                     <a class="closebox"><i class="fa fa-times"></i></a> -->
							</div>
							选择发布位置和任务目标
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-3 control-label">版本号</label>
								<div class="col-md-9">
									<input id="version_id" type="text" name="version_id"
										value="123" onblur="updateVersion(this)">
								</div>
							</div>
							<div  class="form-group">
								<label class="col-sm-3 control-label">发布位置</label>
								<div id="deployment_div" class="col-sm-9">
									<select id="deployment_select" class="js-source-states" name="deployment_id"
										style="width: 100%">
										<option value="1">test1.war.playcrab.com</option>
										<option value="2">test2.war.playcrab.com</option>
										<option value="3">test3.war.playcrab.com</option>
										<option value="4">test4.war.playcrab.com</option>
									</select>
								</div>
							</div>
<!-- 							<div class="hr-line-dashed"></div> -->
<!--                             <div class="form-group"><label class="col-sm-3 control-label">walle worker</label> -->
            
<!--                                 <div class="col-sm-9"> -->
<!--                                      <select class="js-source-states" name="work_id" style="width: 100%">-->
<!--                                         <option value="1">test1.war.playcrab.com</option> -->
<!--                                         <option value="2">test2.war.playcrab.com</option> -->
<!--                                         <option value="3">test3.war.playcrab.com</option> -->
<!--                                         <option value="4">test4.war.playcrab.com</option> -->
<!--                                     </select> -->
<!--                                 </div> -->
<!--                             </div> -->
							<div class="form-group">
								<label class="col-sm-3 control-label">服务端更新包</label>
								<div class="col-md-2 col-md-offset-7">
									<div class="checkbox checkbox-success">
										<input id="upload_server_update_package" type="checkbox"
											name="target_tasks" checked
											value="upload_server_update_package"> <label
											for="upload_server_update_package"> </label>
									</div>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">客户端更新包</label>

								<div class="col-md-2 col-md-offset-7">
									<div class="checkbox checkbox-warning">
										<input id="create_client_update_package" type="checkbox"
											name="target_tasks" checked
											onclick="javascript:checkUpdateClient()"
											value="create_client_update_package"> <label
											for="create_client_update_package"> </label>
									</div>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-md-3 control-label">客户端安装包</label>

								<div class="col-md-2 col-md-offset-7">
									<div class="checkbox checkbox-danger">
										<input id="create_client_package" type="checkbox"
											name="target_tasks" checked
											onclick="javascript:checkClient()"
											value="create_client_package"> <label
											for="create_client_package"> </label>
									</div>
								</div>
							</div>


						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
				<div class="col-lg-6">
					<div id="div2" class="hpanel hgreen">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							选择客户端更新包
						</div>
						<div class="panel-body"
							style="height: 333px; overflow-y: scroll; overflow-x: hidden;">
							<div class="table-responsive" id="version_update_div">
								<table  id="version_update_table" class="table table-condensed table-striped"
									cellpadding="1" cellspacing="1" style="table-layout: fixed;">
									<thead>
										<tr>
											<th>版本号</th>
											<th>发布时间</th>
											<th>是否选择</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="1" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="2" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="3" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="4" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="5" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="6" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="7" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="8" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="9" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="10" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="11" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="12" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="13" checked></td>
										</tr>
										<tr>
											<td>112</td>
											<td>2015-12-28 16:09:22</td>
											<td><input id="chk_all_1" type="checkbox"
												name="package_update_config" value="14" checked></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div id="div3" class="hpanel hgreen">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							发布相关的动态可调整参数
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-4 control-label">打包机</label>

								<div class="col-sm-8">
									<select class="js-source-states" name="work_id"
										style="width: 100%">
										<option value="1">test1.war.playcrab.com</option>
										<option value="2">test2.war.playcrab.com</option>
										<option value="3">test3.war.playcrab.com</option>
										<option value="4">test4.war.playcrab.com</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">日志级别</label>
								<div class="col-sm-8">
									<select class="js-source-states" name="log_level"
										style="width: 100%">
										<option value="DEBUG">DEBUG</option>
										<option value="INFO">INFO</option>
										<option value="WARNING">WARNING</option>
										<option value="ERROR">ERROR</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">并发执行的task数量</label>
								<div class="col-md-8">
									<input id="concurrent_task_count" type="text"
										name="concurrent_task_count" value="1">
								</div>
							</div>

						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
				<div class="col-lg-6">
					<div id="div4" class="hpanel hgreen">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							选择客户端安装包
						</div>
						<div class="panel-body">
							<div class="table-responsive" id="package_div">
								<table id="package_table" class="table table-condensed table-striped"
									cellpadding="1" cellspacing="1" style="table-layout: fixed;">
									<thead>
										<tr>
											<th>安装包</th>
											<th>是否选择</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>appstore_debug</td>
											<td><input id="package_1" type="checkbox"
												name="package_config" value="3" checked></td>
										</tr>
										<tr>
											<td>appstore_release</td>
											<td><input id="package_2" type="checkbox"
												name="package_config" value="1" checked></td>
										</tr>
										<tr>
											<td>appstore_debug</td>
											<td><input id="package_3" type="checkbox"
												name="package_config" value="2" checked></td>
										</tr>
										<tr>
											<td>appstore_release</td>
											<td><input id="package_4" type="checkbox"
												name="package_config" value="4" checked></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-success btn-block">下一步</button>
	
	</form>
</div>
</div>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<script type="text/javascript">
 $(function(){
	 $(".js-source-states").select2(); 
	 $("#publish_form").validate({
         ignore:".ignore",
         rules: {
        	 version_id: {
                 required: true,
                 number:true,
             },
             deployment_id: {
                 required: true,
             },
             work_id: {
                 required: true,
             },
             log_level: {
                 required: true,
             },
             concurrent_task_count: {
                 required: true,
                 number: true
             }
         },
         messages: {
        	 version_id: {
                 required: "请输入版本号",
                 number: "请输入正确的版本号"
             },
             deployment_id: {
                 required: "无发布位置",
             },
             work_id: {
                 required: "无空闲打包机",
             },
             log_level: {
                 required: "无可选日志级别",
             },
             concurrent_task_count: {
                 required: "请输入并发执行的task数量",
                 number: "请输入正确格式的并发执行的task数量"
             },
         },
         submitHandler: function(form) {
             form.submit();
         },
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
 
 function updateVersion(version)
 {
	 var version_value = version.value;
	 if(version_value == "")
	 {
		 return;
	 }
     $.post(
        "/task/jpublish",
         {version_id:version_value},
         function(json){
//                  alert(json);
                 if(json.versionUpdateContent)
                 {
                	 $("#version_update_table").remove();
                	 $("#version_update_div").append(json.versionUpdateContent);
                 }
                 if(json.packageContent)
                 {
                	 $("#package_table").remove();
                	 $("#package_div").append(json.packageContent);
                 }
                 if(json.deploymentContent)
                 {
                	 var deployment_select =  $("#deployment_select");
                	 deployment_select.find("option").remove();
                	 deployment_select.html(json.deploymentContent).select2();
                 }
                 
         },"json"
         );
 }
 </script>
