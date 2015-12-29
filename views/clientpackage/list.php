<?php
use yii\helpers\Html;
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
                安装包下载
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
        <form class="form-inline">
  <div class="form-group">
    <label for="exampleInputName2">版本号</label>
    <input type="text" class="form-control" id="version_id" placeholder="版本号">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">升级序列</label>
    <input type="email" class="form-control" id="upgrade_path" placeholder="升级序列">
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
     <div class="form-group">
    <label for="exampleInputEmail2">部署位置</label>
    <select class="js-source-states" name="platform" >
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
                            <th>升级序列</th>
                            <th>部署位置</th>
                            <th>安装包下载地址</th>
           
                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                         
                        </tr>
                       
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