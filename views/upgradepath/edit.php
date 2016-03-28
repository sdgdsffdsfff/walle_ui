<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                
                     <?php if($id){
                    echo "编辑升级序列";
                }else{
                    echo "新增升级序列";
                }
                ?>
            </h5>
        </div>
    </div>
</div>

<!-- Main Wrapper -->
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-10">
            <div class="hpanel">
               <div class="col-xs-5 col-md-3"></div>
                <div class="col-xs-5 col-md-7">
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                 <form id="upgradepath_form"  class="form-horizontal">
                    <input type="hidden" name="id" id="up_id" value="<?php echo $id;?>"> 
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" >
                    <thead>
                                        <tr>
                                            <th>字段</th>
                                            <th>取值</th>
                                        </tr>
                                    </thead>
                        <tbody>
                       <tr>
                       <td>名称</td>
                       <td><input type="text" id="up_name"  class="form-control" name="up_name" <?php if($id){ echo 'value="'.$info['name'].'"'.' disabled="disabled"'; }?> /> </td>
                   </tr>
                    <tr>
                       <td>描述</td>
                       <td><input type="text" id="up_description" class="form-control"  name="up_description"  value="<?php if($id){echo $info['description'];}?>"/></td> 
                   </tr>
                        <tr>
                            <td>是否启用</td>
                            <td>
                                <input  type="checkbox" class="i-checks checkbox" id="up_option" name="subBox" <?php if($id&&$info['disable']==0) echo "checked";?> ><label></label>  
                            </td> 
                        </tr>
                        </tbody>
                    </table>
                       <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-5">
                                    <button id="create_module_btn" class="btn btn-success" type="submit">保存</button>
                                </div>
                            </div>

                  
                   </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/jquery-validation/jquery.validate.min.js'); ?>
<?= Html::jsFile('@web/static/stringCheck.js'); ?>
<script type="text/javascript">
    $(function () {
            $('#upgradepath_form').validate({
            ignore: '.ignore',
            rules: {
                up_name: {
                    required: true,
                    stringCheck: true
                },
                up_description: {
                    required: true
                },
         
            },
            messages: {
                up_name: {
                    required: '请输入模块英文名称',
                    stringCheck: '只能由英文字母,数字,下划线组成,以英文字母开头'
                },
                up_description: {
                    required: '请输入模块中文描述'
                },
           
            },
            submitHandler: function(form){
                var id=$("#up_id").val();
                var name=$("#up_name").val();
                var description=$("#up_description").val();
                if($("#up_option").is(":checked")){
                    var disable=0;
                }else{
                    var disable=1;
                }
                
                var post = {id : id,name:name,description:description,disable:disable};
                 $.ajax({
                type:'post',
                url:'/upgradepath/doedit',
                data:post,
                dataType:'json',
            }).done(function(data){
                //console.log(data);
                if (data.status == '10000') {
                    swal({ 
                        title:data.data, 
                        type:"success",
                        showConfirmButton: false,
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    },function(){
                        window.location.href="/upgradepath/list"; 
                    });
                }else{
                    swal({ 
                        title:"操作失败", 
                        text:data.data, 
                        type:"error",
                        showConfirmButton: false,
                        confirmButtonColor: "#e74c3c",
                        confirmButtonText: "确认",
                        closeOnConfirm: false
                    });
                }
            });
  
            }
        });
       
    });
</script>