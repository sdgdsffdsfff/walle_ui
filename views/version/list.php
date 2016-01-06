<?php
use yii\helpers\Html;
use \yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/vendor/fooTable/css/footable.core.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
<?= Html::cssFile('@web/static/plugins/bootstrap-datepicker-master/dist/css/bootstrap-datetimepicker.min.css'); ?>
<style>.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 10px 0px;
    border-radius: 4px;
}</style>

<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                版本列表
            </h5>
        </div>
    </div>
</div>

<!-- Main Wrapper -->
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                    高级筛选
            </div>
    <div class="panel-body">
        <form class="form-inline" action="/version/list">
  <div class="form-group">
    <label for="exampleInputName2">版本号</label>
    <input type="text" class="form-control" name="vid" value="<?php echo $vid;?>" placeholder="版本号" size=10>
  </div>
      <div class="form-group">
    <label for="exampleInputEmail2">创建人</label>
    <input type="text" class="form-control" name="create_user" placeholder="创建人" value="<?php echo $create_user;?>" size=10> 
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">升级序列</label>
    <select class="js-source-states" name="upgrade_path_id" style="width:180px">
                                    <optgroup label="请选择升级序列">
                                         <option value="">请选择升级序列</option>
                                        <?php 

                                        foreach ($upgradePath as $v) {
                                            if(isset($upgrade_path_id)&&!empty($upgrade_path_id)&&$upgrade_path_id==$v['id']){
                                                echo " <option value='".$v['id']."' selected>".$v['name']."</option>";
                                            }else{
                                             echo " <option value='".$v['id']."'>".$v['name']."</option>";
                                            }
                                            
                                        }
                                        ?>
                                    </optgroup>
                                </select>
  </div>

     <div class="form-group">
    <label for="exampleInputEmail2">平台</label>
    <select class="js-source-states" name="platform_id" style="width:180px" >
                                    <optgroup label="请选择发行区域-平台">
                                        <option value="">请选择发行区域-平台</option>
                                        <?php 
                                        foreach ($platform as $v) {
                                             if(isset($platform_id)&&!empty($platform_id)&&$platform_id==$v['id']){
                                                 echo " <option value='".$v['id']."' selected>".$v['region']['description']."-".$v['name']."</option>";
                                            }else{
                                                echo " <option value='".$v['id']."'>".$v['region']['description']."-".$v['name']."</option>";
                                            }
                                           
                                        }
                                        ?>
                                    </optgroup>
                                </select>
  </div>
    <div class="form-group">
    <label for="exampleInputEmail2">上线状态</label>
    <select class="js-source-states" name="release" >
                                    <optgroup label="请选择">
                                         <option value="">请选择</option>
                                   <option value="1" <?php if($release==1){echo "selected";}?>>已上线</option>
                                   <option value="2" <?php if($release==2){echo "selected";}?>>未上线</option>
                                    </optgroup>
                                </select>
  </div>
  <button type="submit" class="btn btn-warning" >查询</button>
</form>

    </div>

                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 10px;">
                     
                  <div style="float:right">
                    <?php echo LinkPager::widget([
    'pagination' => $pages
]); ?>
              </div> 
              <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
                <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th data-toggle="true">版本号</th>
                            <th>时间</th>
                            <th>平台</th>
                            <th>升级序列</th>
                            <th>创建人</th>
                            <th>change log</th>
                            <th>业务模块版本</th>
                            <th>上线时间</th>
                            <th>操作</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                             
                             
                           <?php 
                            foreach ($models as $k) {
                                echo "<tr>";
                                echo '<td><a style="text-decoration:underline" href="/version/add-version?id='.$k['id'].'">'.$k['id'].'</a></td>';
                                echo "<td>".$k['create_time']."</td>";
                                echo "<td>".$k['platform']['description']."</td>";
                                echo "<td>".$k['upgradePath']['name']."</td>";
                                echo "<td>".$k['create_user']."</td>";
                                echo "<td>".$k['change_log']."</td>";
                                echo "<td>".$k['change_log']."</td>";
                                if($k['released']==1){
                                    echo "<td>".$k['release_time']."</td>";
                                }else{
                                    echo '<td> <button type="button" class="btn-primary" data-toggle="modal"  data-id="'.$k['id'].'">设置时间
                                </button></td>';
                                }
                                
                                echo '<td><a href="/task/publish?id='.$k['id'].'" class="btn btn-info btn-sm active" >发布版本</a>
<a href="/task/list" class="btn btn-success btn-sm active" >查看相关任务</a></td>';
                                echo "</tr>";
                            }
                            ?> 
                       
                        </tbody>

                    </table>

  <div style="float:right">
                    <?php echo LinkPager::widget([
    'pagination' => $pages
]); ?>
              </div> 
              <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
                </div>

            </div>

        </div>

    </div>
    </div>
    <input type="hide" name="set_id" id="set_id" value=""> 
          <div class="modal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="color-line"></div>
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal title</h4>
                                    <small class="font-bold">设置时间</small>
                                </div>
                                <div class="modal-body">
                                    
                            <div class="input-group date">
                            <input type="text" class="form-control" size="20" value="2016-01-1 21:05:00" id="datetimepicker" data-date-format="yyyy-mm-dd hh:ii:ss">
                           
                        </div>
                  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="button" class="btn btn-primary" id="save">保存</button>
                                </div>
                            </div>
                        </div>
                    </div>

    <!-- Footer-->

<!-- Vendor scripts -->

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/bootstrap-datepicker-master/dist/js/bootstrap-datetimepicker.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/bootstrap-datepicker-master/dist/js/bootstrap-datetimepicker.zh-CN.js'); ?>


<script>

    $(function () {
          $('#datetimepicker').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
         format: 'yyyy-mm-dd hh:ii:ss'
    });
 $(".js-source-states").select2();
 $("#save").click(function(){
    var id=$("#set_id").val();
    var t=$("#datetimepicker").val();
    var post = {id : id,release_time:t}
                    $.ajax({
                      type:'post',
                      url:'/version/released',
                      data:post,
                      dataType:'json',
                    }).done(function(data){
                      if (data.info == '1') {
                            alert( JSON.stringify(data.msg)); 
                            location.reload();
                        }else{
                            alert(JSON.stringify(data.msg));
                        }
                    });


 })

   $(".btn-primary").click(function() {
                    var id = $(this).attr('data-id');
                    $("#set_id").val(id);

                    $("#myModal6").modal('show');
                 
                  });
    });

</script>

</body>
</html>