<?php
use yii\helpers\Html;
?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                更新模块版本
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-body">
                    <form class="form-horizontal">
                          <table  class="table table-bordered table-striped" data-page-size="8" data-filter=#filter>
                        <thead>
                        <tr>

                            <th data-toggle="true">模块名称</th>
                            <th>是否更新</th>
                           
                            
                        </tr>
                        </thead>
                        <tbody>
                            <?php 

                           foreach ($models as $k) {
                              echo "<tr>";
                              echo "<td>".$k['name']."</td>";
                              echo '<td><input type="checkbox" name="module" value="'.$k['id'].'"> </td>';
                              echo "</tr>";
                           }
                            ?>
                       
                        </tbody>
                        
                    </table>
                    <button type="submit" class="btn w-xs btn-success">更新模块版本列表</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
        <div class="hpanel"> <div class="panel-body">
滚动日志
        </div></div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<script type="text/javascript">
    $(function(){
        $(".js-source-states").select2();
    });
    
    $('.summernote2').summernote({
        airMode: true
    });
</script>