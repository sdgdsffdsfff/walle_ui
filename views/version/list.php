<?php
use yii\helpers\Html;
use \yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/vendor/fooTable/css/footable.core.min.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-3.5.2/select2.css'); ?>
<?= Html::cssFile('@web/static/plugins/select2-bootstrap/select2-bootstrap.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote.css'); ?>
<?= Html::cssFile('@web/static/plugins/summernote/dist/summernote-bs3.css'); ?>
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
    <select class="js-source-states" name="upagrade_path_id" >
                                    <optgroup label="请选择发行区域-平台">
                                        <option value="AK">大陆发行-appstore</option>
                                        <option value="HI">海外发行-appstore</option>
                                    </optgroup>
                                </select>
  </div>

     <div class="form-group">
    <label for="exampleInputEmail2">平台</label>
    <select class="js-source-states" name="platform_id" >
                                    <optgroup label="请选择发行区域-平台">
                                        <option value="AK">大陆发行-appstore</option>
                                        <option value="HI">海外发行-appstore</option>
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
                            <th>操作</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                             <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                   
                    </tr>
                                <tr>
                        <td><a style="text-decoration:underline" href="#">122</a></td>
                        <td>96</td>
                        <td>deploy1.saiya.playcrab-inc.com</td>
                        <td>2015-12-28 22:22:10</td>
                        <td>2015-12-28 22:42:10</td>
                        <td>成功</td>
                        <td>liuhaiyang</td>
                        <td>生成安装包</td>
                   
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


    <!-- Footer-->

<!-- Vendor scripts -->

<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>

<script>

    $(function () {
 $(".js-source-states").select2();
    });

</script>

</body>
</html>