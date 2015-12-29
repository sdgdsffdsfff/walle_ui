<?php
use yii\helpers\Html;
?>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <h5>更新模块版本</h5>
                </div>
            </div>
        </div>
    </div>
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
                        <tr>
                            <td>frontend</td>
                            <td><input type="checkbox"> </td>
                           
                        </tr>
                       <tr>
                            <td>backend</td>
                            <td><input type="checkbox"> </td>
                           
                        </tr>
                        <tr>
                            <td>script</td>
                            <td><input type="checkbox"> </td>
                           
                        </tr>
                        <tr>
                            <td>global</td>
                            <td><input type="checkbox"> </td>
                           
                        </tr>

                        </tbody>
                        
                    </table>
                    <button type="submit" class="btn btn-default">更新模块版本列表</button>
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