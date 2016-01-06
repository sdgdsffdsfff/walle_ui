<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
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
                            <th> <div class="checkbox checkbox-success">
                                        <input  type="checkbox" id="checkAll" checked> <label >是否更新 </label>
                                    </div></th>
                           
                            
                        </tr>
                        </thead>
                        <tbody>
                            <?php 

                           foreach ($models as $k) {
                              echo "<tr>";
                              echo "<td>".$k['name']."</td>";
                              echo '<td><div class="checkbox checkbox-success"> <input  type="checkbox" name="subBox" checked value="'.$k['id'].'"><label></label></div> </td>';
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

         $("#checkAll").click(function() {
                 $('input[name="subBox"]').prop("checked",this.checked);  
            });
            var $subBox = $("input[name='subBox']");
            $subBox.click(function(){
                $("#checkAll").attr("checked",$subBox.length == $("input[name='subBox']:checked").length ? true : false);
            });
    });
    
    $('.summernote2').summernote({
        airMode: true
    });
</script>