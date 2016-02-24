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
                编辑upgrade path
            </h5>
        </div>
    </div>
</div>

<!-- Main Wrapper -->
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <!--<div class="panel-heading">
                    高级筛选
                </div>-->
                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                  <form id="upgradepath_form" method="get" class="form-horizontal">
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" style="width:50%;margin-left:200px;margin-right:200px">
                   
                        <tbody>
                       <tr>
                       <td>名称</td>
                       <td><input type="text" id="up_name"  class="form-control" name="up_name"/> </td>
                   </tr>
                    <tr>
                       <td>描述</td>
                       <td><input type="text" id="up_description" class="form-control"  name="up_description"  /></td> 
                   </tr>
                        <tr>
                        <td>是否启用</td>
                        <td><div class="checkbox checkbox-success"> <input  type="checkbox" id="up_option" name="subBox" checked ><label></label></div>  </td> </tr>
                        </tbody>
                    </table>
                       <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-5">
                                    <button id="create_module_btn" class="btn btn-success" type="submit">新增/保存</button>
                                </div>
                            </div>
</form>
                  
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
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
                form.submit();
            }
        });
       
    });
</script>