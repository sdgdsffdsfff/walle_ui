<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                查看upgrade path
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
                    <form class="form-inline">
                  
     
   
                             <a  class="btn btn-success" href="/upgradepath/edit" style="margin-left: 20px;">新增</a>

                    </form>
                </div>
                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                  
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>升级序列名称</th>
                                 <th>是否启用</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                       <td>1</td>
                       <td>ios</td>
                       <td><div class="checkbox checkbox-success" style="margin:0"> <input type="checkbox"/><label></label></div></td>
                       <td>200</td>
                        <td><a  class="btn btn-info btn-sm active" href="/upgradepath/edit?id='.$k['id'].'" >编辑</a>
                            <a  class="btn btn-danger btn-sm active" >删除</a>
    <a href="/task/list?version_id='.$k['id'].'" class="btn btn-success btn-sm active"  >查看升级序列相关配置</a>

    <a href="/upgradepath/copy?vid='.$k['id'].'" class="btn btn-warning btn-sm active" >复制升级序列相关配置</a></td>
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