<?php
use yii\helpers\Html;
use \yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/fooTable/css/footable.core.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
<?= Html::cssFile('@web/static/plugins/bootstrap-datepicker-master/dist/css/bootstrap-datetimepicker.min.css'); ?>

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
    <input type="text" class="form-control" id="id" placeholder="版本号">
  </div>
      <div class="form-group">
    <label for="exampleInputEmail2">创建人</label>
    <input type="email" class="form-control" id="create_user" placeholder="创建人">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">升级序列</label>
    <select class="js-source-states" name="upagrade_path_id" style="width:200px">
                                    <optgroup label="请选择升级序列">
                                         <option value="">请选择升级序列</option>
                                        <?php 
                                        // foreach ($platform as $v) {
                                        //     echo " <option value='".$v['id']."'>".$v['name']."</option>";
                                        // }
                                        ?>
                                    </optgroup>
                                </select>
  </div>

     <div class="form-group">
    <label for="exampleInputEmail2">平台</label>
    <select class="js-source-states" name="platform_id" style="width:200px" >
                                    <optgroup label="请选择发行区域-平台">
                                        <option value="">请选择发行区域-平台</option>
                                        <?php 
                                        // foreach ($platform as $v) {
                                        //     echo " <option value='".$v['id']."'>".$v['region']['description']."-".$v['name']."</option>";
                                        // }
                                        ?>
                                    </optgroup>
                                </select>
  </div>
  <button type="submit" class="btn btn-primary" >搜索</button>
</form>

    </div>

                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
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
                             <tr>
                        <td><a style="text-decoration:underline" href="/version/version-detail">122</a></td>
                        <td>2015-12-28 22:42:10<</td>
                        <td>大陆发行-appstore</td>
                        <td>23sdsfappstore</td>
                        <td>zhaoshuang</td>
                        <td>成功</td>
                        <td>frontend:master.1512.34.45</br>
                            backend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                        </td>
                        <td> 
                             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal6">
                       设置时间
                    </button>
                        </td>
                        <td><a href="/version/add-version" class="btn btn-info btn-sm active" >发布版本</a>
<a href="/task/list" class="btn btn-success btn-sm active" >查看相关任务</a></td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                         <td>frontend:master.1512.34.45</br>
                            backend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                        </td>
                        <td>2015-12-28 22:42:10</td>
                        <td><a href="/version/add-version" class="btn btn-info btn-sm active" >发布版本</a>
<a href="/task/list" class="btn btn-success btn-sm active" >查看相关任务</a></td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                          <td>frontend:master.1512.34.45</br>
                            backend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                        </td>
                        <td>2015-12-28 22:42:10</td>
                        <td><a href="/version/add-version" class="btn btn-info btn-sm active" >发布版本</a>
<a href="/task/list" class="btn btn-success btn-sm active" >查看相关任务</a></td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                          <td>frontend:master.1512.34.45</br>
                            backend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                            frontend:master.1512.34.45</br>
                        </td>
                        <td> <button type="button" class="btn btn-primary btn-sm">设置时间</button></td>
                        <td><a href="/version/add-version" class="btn btn-info btn-sm active" >发布版本</a>
<a href="/task/list" class="btn btn-success btn-sm active" >查看相关任务</a></td>
                   
                    </tr>
                             
                           <?php 
                            // foreach ($models as $k) {
                            //     echo "<tr>";
                            //     echo "<td>".$k['id']."</td>";
                            //     echo "<td>".$k['create_time']."</td>";
                            //     echo "<td>".$k['platform_id']."</td>";
                            //     echo "<td>".$k['upgrade_path_id']."</td>";
                            //     echo "<td>".$k['create_user']."</td>";
                            //     echo "<td>".$k['change_log']."</td>";
                            //     echo "<td>".$k['change_log']."</td>";
                            //     echo "<td>".$k['change_log']."</td>";
                            //     echo "</tr>";
                            // }
                            ?> 
                       
                        </tbody>

                    </table>


                </div>
                    <div class="panel-footer">
            <!-- 需要使用风格一致的分页-->
                <div class="btn-group">
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
                    <button class="btn btn-default active">1</button>
                    <button class="btn btn-default">2</button>
                    <button class="btn btn-default">3</button>
                    <button class="btn btn-default">4</button>
                    <button class="btn btn-default">5</button>
                    <button class="btn btn-default">6</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            </div>

        </div>

    </div>
    </div>
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
                            <input type="text" class="form-control" size="16" value="2016-01-1 21:05" id="datetimepicker" data-date-format="yyyy-mm-dd hh:ii">
                           
                        </div>
                  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="button" class="btn btn-primary">保存</button>
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
         format: 'yyyy-mm-dd hh:ii'
    });
 $(".js-source-states").select2();
    });

</script>

</body>
</html>