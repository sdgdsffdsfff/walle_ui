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
                平台信息列表
            </h5>
        </div>
    </div>
</div>

<!-- Main Wrapper -->
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4">
                    <a href="/platform/edit" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
               
<!--                    <a href="/platform/edit" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>-->

                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                  
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>发行地区</th>
                                <th>平台名称</th>
                                 <th>是否启用</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            if($data){
                                foreach ($data as $k => $v) {
                                    echo "<tr>";
                                    echo "<td>".$v['id']."</td>";
                                    echo "<td>".$v['region']['name']."</td>";
                                   echo "<td>".$v['name']."</td>";
                                      if($v['disable']==0){
                                     echo '<td style="color:#66CD00">是</td>';
                                   }else{
                                     echo '<td style="color:red;">否</td>';
                                 }
                                    echo "<td>".$v['description']."</td>";
                                    echo '<td align="center"><a  class="btn btn-info btn-sm active" href="/platform/edit?id='.$v['id'].'" >编辑</a></td>';
                                    echo "</tr>";
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

<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<?= Html::jsFile('@web/static/codymenu.js'); ?>
<script type="text/javascript">
    $(function () {
        $(".js-source-states").select2();

    });
</script>