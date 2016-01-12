<?php
use yii\helpers\Html;
?>
<?= Html::cssFile('@web/static/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css'); ?>
<?= Html::cssFile('@web/static/plugins/sweetalert/lib/sweet-alert.css'); ?>
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
                              echo '<td><div class="checkbox checkbox-success"> <input  type="checkbox" name="subBox" checked value="'.$k['name'].'"><label></label></div> </td>';
                              echo "</tr>";
                           }
                            ?>
                       
                        </tbody>
                        
                    </table>
                    <button type="button" class="btn w-xs btn-primary" >更新模块版本列表</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
        <div class="hpanel"> <div class="panel-body"
                            >滚动日志
                            <div style="height: 300px; overflow-y: scroll; overflow-x: hidden;" id="div_logs">

                            </div>


        </div></div>
        </div>
    </div>
</div>

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<?= Html::jsFile('@web/static/FileReaderClient.js'); ?>
<?= Html::jsFile('@web/static/plugins/sweetalert/lib/sweet-alert.min.js'); ?>
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


        $(".btn-primary").click(function() {
          $(this).attr("disabled","disabled");
         cat();
          var chk_value =[]; 
        $("input[name='subBox']:checked").each(function(){ 
        chk_value.push($(this).val()); 
        }); 

            var post = {chk_value : chk_value};
            $.ajax({
                type:'post',
                url:'/module/update',
                data:post,
                dataType:'json',
            }).done(function(data){
                console.log(data);
                if (data.status == '1') {
                    swal({ title:"模块更新", text:data.data, type:"success",timer: 5000,
                        showConfirmButton: false});
                    location.reload();
                }else{
                    swal({ title:"模块更新", text:data.data, type:"error"});
                    $(this).removeAttr("disabled");
                }
            });

        });
    });
    
    $('.summernote2').summernote({
        airMode: true
    });

    function cat() {
            var ws_url = 'ws://172.16.30.50:9003';
            var log_path = '/data/work/log/nginx/access.log';
            var pid = 0;
            var div_id = 'div_logs';
            document.getElementById(div_id).innerHTML = '';
            FileReaderClient.cat(ws_url, pid, log_path, div_id);
        }
</script>