<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/fooTable/css/footable.core.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                查看platform
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
                <div class="panel-body">
          
                  
     <a  class="btn btn-success" href="/platform/edit" style="margin-left: 20px;">新增</a>
   
  
                </div>
                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                  
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>名称</th>
                                 <th>是否启用</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                       <td>1</td>
                       <td>ios</td>
                       <td><input type="checkbox"/></td>
                       <td>200</td>
                        <td><a  class="btn btn-info btn-sm active" href="/platform/edit?action=opt&id='.$k['id'].'" >编辑</a>
                            <a  class="btn btn-danger btn-sm active" >删除</a>
</td>
                        </tbody>
                    </table>
                   
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