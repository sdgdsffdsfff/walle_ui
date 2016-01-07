<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<?= Html::cssFile('@web/static/plugins/fooTable/css/footable.core.min.css'); ?>
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
                <!--<div class="panel-heading">
                    高级筛选
                </div>-->
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="exampleInputName2">版本号：</label>
                            <input type="text" class="form-control" name="vid" value="<?php echo $vid; ?>" placeholder="版本号" style="margin-right: 20px;" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail2">升级序列：</label>
                            <select class="js-source-states" name="upgrade_path_id" style="width:200px; margin-right: 20px;">
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
                            <label for="exampleInputEmail2">平台：</label>
                            <select class="js-source-states" name="platform_id" style="margin-right: 20px;">
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
                            <label for="exampleInputEmail2">发布位置：</label>
                            <select class="js-source-states" name="deployment_id" style="margin-right: 20px;">
                                <optgroup label="请选择发布位置">
                                    <option value="">请选择发布位置</option>
                                    <?php 
                                        foreach ($deployment as $v) {
                                             if(isset($deployment_id)&&!empty($deployment_id)&&$deployment_id==$v['id']){
                                                echo " <option value='".$v['id']."' selected>".$v['name']."</option>";
                                            }else{
                                                echo " <option value='".$v['id']."'>".$v['name']."</option>";
                                            }
                                        }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning" style="margin-left: 20px;">查询</button>
                    </form>
                </div>
                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                    <div style="float:right">
                       <?php echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div> 
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
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
                            <?php 
                                foreach ($models as $k) {

                                    echo "<tr>";
                                    echo '<td><a style="text-decoration:underline" href="/version/version-detail?version_id='.$k['id'].'">'.$k['id'].'</a></td>';
                                    echo "<td>".$k['upgrade_name']."</td>";
                                    echo "<td>".$k['deployment_name']."</td>";
                                    echo "<td>".$k['url']."</td>";
                                    echo "</tr>";

                                }
                            ?> 
                        </tbody>
                    </table>
                    <div style="float:right">
                        <?php echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div> 
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php echo $pageCount;?> /总记录数：<?php echo $totalCount;?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/plugins/select2-3.5.2/select2.min.js'); ?>
<?= Html::jsFile('@web/static/plugins/summernote/dist/summernote.min.js'); ?>
<script type="text/javascript">
    $(function () {
        $(".js-source-states").select2();
    });
</script>