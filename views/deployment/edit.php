<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                编辑deployment
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
                  
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" style="width:50%;margin-left:200px;margin-right:200px">
                   
                        <tbody>
                           <tr>
                       <td>平台</td>
                       <td>
                          <select class="js-source-states" id="new_platform" name="new_platform" style="width: 100%">
                                    <option value="">请选择平台</option>
                                   
                                </select>
                                </td>
                   </tr>
                       <tr>
                       <td>名称</td>
                       <td><input type="text"  class="form-control" name="showname"  /> </td>
                   </tr>
                    <tr>
                       <td>描述</td>
                       <td><input type="text"  class="form-control"  name="description"  /></td> 
                   </tr>
                        <tr>
                        <td>是否启用</td>
                        <td><div class="checkbox checkbox-success"> <input  type="checkbox" name="subBox" checked ><label></label></div>  </td> </tr>
                        </tbody>
                    </table>

                   <div style="width:50%;margin-left:400px;"> <button type="button" class="btn w-xs btn-primary" id="uptag">新增/保存</button></div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<?= Html::jsFile('@web/static/codymenu.js'); ?>
<script type="text/javascript">
    $(function () {
        $(".js-source-states").select2();
       
    });
</script>