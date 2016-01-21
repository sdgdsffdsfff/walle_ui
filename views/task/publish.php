<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweetalert2.css'); ?>
<?= Html::cssFile('@web/static/plugins//toastr/build/toastr.min.css'); ?>

<div class="normalheader transition small-header">
	<div class="hpanel">
		<div class="panel-body">
			<h5 class="font-light m-b-xs">发布任务</h5>
		</div>
	</div>
</div>
<div class="content animate-panel">
	<form id="publish_form" method="post" class="form-horizontal"
		action="/task/republish">
		<input name="_csrf" type="hidden" id="_csrf"
			value="<?= Yii::$app->request->csrfToken ?>">
		<div class="content">
			<div class="row">
				<div class="col-lg-6">
					<div class="hpanel">
						<div class="panel-heading hbuilt">
							<div class="panel-tools">
								<!--                     <a class="showhide"><i class="fa fa-chevron-up"></i></a> -->
								<!--                     <a class="closebox"><i class="fa fa-times"></i></a> -->
							</div>
							选择发布位置和任务目标
						</div>
						<div class="panel-body" style="height: 300px; overflow-y: scroll; overflow-x: hidden;">
							<div class="form-group">
								<label class="col-sm-3 control-label">版本号</label>
								<div class="col-md-9">
									<input id="version_id" type="text" name="version_id" class="form-control" 
										value="<?php echo empty($data['version']['id'])? '':$data['version']['id']?>" placeholder="请输入版本号"  onblur="updateVersion(this)">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">发布位置</label>
								<div id="deployment_div" class="col-sm-9">
                                       	<?php echo $data['deploymentListContent']?>
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
											name="target_tasks[]" checked
											value="create_server_update_package"> <label
											for="create_server_update_package"> </label>
									</div>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">客户端更新包</label>

								<div class="col-md-2 col-md-offset-7">
									<div class="checkbox checkbox-warning">
										<input id="create_client_update_package" type="checkbox"
											name="target_tasks[]"  
											<?php if (!$data['isVersionsUpdatePackage']) 
    										{
    										    echo "disabled";
    										}
    										else
    										{
    										    echo  "checked";
    										}
                                            ?>
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
											name="target_tasks[]" 
											onclick="javascript:checkClient()"
											value="create_client_package"
											<?php if (!$data['isPackageListContent']) 
    										{
    										    echo "disabled";
    										}
                                            ?>> <label
											for="create_client_package"> </label>
									</div>
								</div>
							</div>


						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
				<div class="col-lg-6">
					<div id="div2" class="hpanel ">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							<div class="row">
								<div class="col-sm-6">选择客户端更新包</div>
								<div class="col-sm-6">
									<input id="chk_update_all" type="checkbox"
										name="chk_update_all" <?php if ($data['isVersionsUpdatePackage']) 
    										{
    										   echo  "checked";
    										}
                                            ?> value="1"
										onclick="chkUpdateAll()" />选择全部
								</div>
							</div>
						</div>
						<div class="panel-body"
							style="height: 300px; overflow-y: scroll; overflow-x: hidden;">
							<div class="table-responsive" id="version_update_div">
								<table id="version_update_table" class="table table-condensed table-striped" cellpadding="1" cellspacing="1"  style="table-layout:fixed;" >
                                    <thead>
                                    <tr>
                                    <th>版本号</th>
                                    <th>创建时间</th>
                                    <th>上线时间</th>
                                    <th>是否选择</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php  foreach ($data['versionUpdateList'] as $key => $value) {?>
                                             <tr>
                                                   <td><?php echo $value['id']?></td>
                                                   <td><?php echo $value['create_time']?></td>
                                                   <td><?php echo $value['release_time']?></td>
                                                   <td><input id="chk_all_<?php echo $key?>"  type="checkbox" name="package_update_config[]" value="<?php echo $value['id']?>" checked></td>
                                           </tr>
                                       <?php }?>
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
					<div id="div3" class="hpanel">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							发布相关的动态可调整参数
						</div>
						<div class="panel-body" style="height: 300px; overflow-y: scroll; overflow-x: hidden;">
							<div class="form-group">
								<label class="col-sm-4 control-label">打包机</label>

								<div class="col-sm-8">
									<select class="js-source-states" name="worker_id"
										style="width: 100%">
										<?php foreach ($data['workerList'] as $value) {?>
                                            <option value="<?php echo $value['id']?>" <?php echo  $data['freeWorker']['id'] == $value['id'] ? ' selected="selected"' : ''?>><?php echo Html::encode($value['hostname']);?></option>
                                        <?php }?>
									</select>
								</div>
							</div>
							<?php echo $data['dynamicConfigContent']?>
                            
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
				<div class="col-lg-6">
					<div id="div4" class="hpanel">
						<div class="panel-heading hbuilt">
							<div class="panel-tools"></div>
							<div class="row">
								<div class="col-sm-6">选择客户端安装包</div>
								<div class="col-sm-6">
									<input id="chk_install_all" type="checkbox"
										name="chk_install_all" value="1" onclick="chkInstallAll()" />选择全部
								</div>
							</div>

						</div>
						<div class="panel-body" style="height: 300px; overflow-y: scroll; overflow-x: hidden;">
							<div class="table-responsive" id="package_div">
								<table id="package_table" class="table table-condensed table-striped" cellpadding="1" cellspacing="1"  style="table-layout:fixed;" >
                                    <thead>
                                    <tr>
                                    <th>安装包</th>
                                    <th>是否选择</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php  foreach ($data['packageList'] as $key => $value) {?>
                                             <tr>
                                                   <td><?php echo $value['name']?></td>
                                                   <td><input id="package_<?php echo $key?>"  type="checkbox" name="package_config[]" value="<?php echo $value['id']?>"></td>
                                           </tr>
                                       <?php }?>
                                    </tbody>
                                 </table>   
							</div>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>
			<button id="create_job_button" type="button"
				class="btn btn-success btn-block">创建任务</button>
	
	</form>
</div>
</div>
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header">
                <h4 class="modal-title">提示</h4>
                <!--<small class="font-bold">设置时间</small>-->
            </div>
            <div class="modal-body">
                <div class="input-group date">
                    任务发布中，请等待。。。。。。。
                </div>
            </div>
          
        </div>
    </div>
</div>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweetalert2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/toastr/build/toastr.min.js'); ?>

<script type="text/javascript">
 $(function(){
	 $("#deployment_select").change(function(){ 
		    $(this).valid();  
		});  
	 $("#deployment_select").blur(function(){
		    $(this).valid();  
	 		});
     $('#version_id').change(function(){
         $('#deployment_select').valid();
     });
	 toastr.options = {
	            "debug": false,
	            "newestOnTop": false,
	            "positionClass": "toast-top-center",
	            "closeButton": true,
	            "debug": false,
	            "toastClass": "animated fadeInDown",
	        };
     
	 if($('#create_client_package').prop('checked')==false)
	 {
		 $("#div4").hide(); 
     }
	
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
//              log_level: {
//                  required: true,
//              },
//              concurrent_task_count: {
//                  required: true,
//                  number: true
//              }
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
         },
//          submitHandler: function(form) {
//              form.submit();
//          },
     }); 
	 var submiting = 0;
	 $('#create_job_button').click(function(){
		 if($("#publish_form").valid()){
			
    		 swal({
    			    title: "发布任务确认",
    			    text: "",
    			    type: "warning",
    			    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确认",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
//                     closeOnCancel: false 
                    },
                    function (isConfirm) {
                    if (isConfirm) {
                    	swal.disableButtons();
//                     	 $("#myModal6").modal('show');
                    	 if(submiting == 0)
                 		 {
                 			submiting = 1;
                 		 }else
                 		 {
                     		 return;
                     	 }
                    	 $.ajax({
                             type: "POST",
                             url: '/task/dopublish',
                             data:$('#publish_form').serialize(),// 要提交的表单 
                             dataType: "json", 
                             success: function(json) {
                            	 if(json.status == '40003')
                                 {
                                     swal({
                                         title: "权限提示",
                                         text: json.description,
                                         type: "warning",
                                         showCancelButton: false, //是否显示'取消'按钮
                                         confirmButtonColor: "#e74c3c",
                                         confirmButtonText: "确认",
                                         closeOnConfirm: false,
                                     });
                                 }
                                 else{
                                    	 if(json.status == 10000)
                                         {
//                                         	 toastr.success(json.description);
//                                         	 $("#myModal6").modal('hide');
                                        	 var jobId = json.data;
                                        	 window.location.href="/task/detail?job_id="+jobId;
                                         }
                                         else
                                         {
    //                                     	 toastr.error(json.description);
                                        	  swal("提示", json.description, "error"); 
                                         }
                                     }
                            	 submiting = 0;
                            
                             }
                        });
                       
                    } 
			});
		  }
     });

	<?php echo $data['rules']?>
 });
 function chkUpdateAll()
 {
     var val = $('#chk_update_all').prop('checked');
     if(val == true)
     {
         $('#version_update_div :checkbox').prop('checked', true);
     }
     if(val == false)
     {
         $('#version_update_div :checkbox').prop('checked', false);
     }
 }
 function chkInstallAll()
 {
     var val = $('#chk_install_all').prop('checked');
     if(val == true)
     {
         $('#package_div :checkbox').prop('checked', true);
     }
     if(val == false)
     {
         $('#package_div :checkbox').prop('checked', false);
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
	 $("#version_update_table").remove();
	 $("#package_table").remove();
	 var deployment_select =  $("#deployment_select");
	 deployment_select.html("").select2();

	 $('#chk_update_all').prop('disabled',true);
	 $('#chk_update_all').prop('checked',false);
	 $('#create_client_update_package').attr('disabled',true);
	 $('#create_client_update_package').attr('checked',false);

	 $('#chk_install_all').attr('disabled',true);
	 $('#chk_install_all').prop('checked',false);
	 $('#create_client_package').attr('disabled',true);
	 $('#create_client_package').prop('checked',false);
     
	 if(version_value == "")
	 {
		 return;
	 }
     $.post(
        "/task/jpublish",
         {version_id:version_value},
         function(json){
        	 if(json.status == '40003')
             {
                 swal({
                     title: "权限提示",
                     text: json.description,
                     type: "warning",
                     showCancelButton: false, //是否显示'取消'按钮
                     confirmButtonColor: "#e74c3c",
                     confirmButtonText: "确认",
                     closeOnConfirm: false,
                 });
             }
             else{
        	     if(json.status == 10000){
        	    	 toastr.success("切换版本数据成功");
                     if(json.data.versionUpdateContent)
                     {
                    	 $('#chk_update_all').prop('disabled',false);
                    	 $('#chk_update_all').prop('checked',true);
                    	 $('#create_client_update_package').prop('disabled',false);
                    	 $('#create_client_update_package').prop('checked',true);
                    	 $("#version_update_div").append(json.data.versionUpdateContent);
                     }
                     else
                     {
                    	 $('#chk_update_all').prop('disabled',true);
                    	 $('#chk_update_all').prop('checked',false);
                    	 $('#create_client_update_package').prop('disabled',true);
                    	 $('#create_client_update_package').prop('checked',false);
                     }
                     if(json.data.packageListContent)
                     {
                    	 $('#chk_install_all').prop('disabled',false);
                    	 $('#chk_install_all').prop('checked',false);
                    	 $('#create_client_package').prop('disabled',false);
                    	 $("#package_div").append(json.data.packageListContent);
                     }
                     else
                     {
                    	 $('#chk_install_all').prop('disabled',true);
                    	 $('#chk_install_all').prop('checked',false);
                    	 $('#create_client_package').prop('disabled',true);
                    	 $('#create_client_package').prop('checked',false);
                     }
                     $("#div4").hide();
                     if(json.data.deploymentListContent)
                     {
                    	 deployment_select.html(json.data.deploymentListContent).select2();
                     }
                     deployment_select.valid();
        	     }else{
        	    	 toastr.error(json.description);
        	    	 version.value=""; 
            	 }
             }
                 
         },"json"
         );
 }
 </script>
