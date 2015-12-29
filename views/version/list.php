<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

?>
<?= Html::cssFile('@web/static/vendor/fooTable/css/footable.core.min.css'); ?>
<!-- Main Wrapper -->
    <div class="normalheader transition animated fadeIn">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="footable.html">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <h2 class="font-light m-b-xs">
                    版本列表
                </h2>
              
            </div>
        </div>



<div class="content animate-panel">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    
                    </div>
                    高级筛选
                </div>
                <div class="panel-body">
<div class="row">

    <div class="col-xs-3 input-append">
        <span class="add-on">版本号</span>
        <input class="input-sm" type="text" placeholder="版本号">

</div>

    <div class="col-xs-3 input-append">
        <span class="add-on">升级序列</span>
        <input class="input-sm" type="text" placeholder="升级序列">

</div>
<div class="col-xs-3 input-append">
        <span class="add-on">创建人</span>
        <input class="input-sm" type="text" placeholder="创建人">

</div>
</div>
<div class="row">
<div class="col-xs-3 input-append">
        <span class="add-on">平台</span>
        <input class="input-sm" type="text" placeholder="平台">

</div>
</div>
                    
                </div>
                <div style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">

                   
                    <table  class="table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter>
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
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                            <td><span class="pie">6,9</span></td>
                            <td>40%</td>
                            <td>Jul 16, 2013</td>
                        </tr>
                        <tr>
                            <td>Betha project</td>
                            <td>John Smith</td>
                            <td>0800 1111</td>
                            <td>Erat Volutpat</td>
                            <td><span class="pie">3,1</span></td>
                            <td>75%</td>
                            <td>Jul 18, 2013</td>
                        </tr>
                        <tr>
                            <td>Gamma project</td>
                            <td>Anna Jordan</td>
                            <td>(016977) 0648</td>
                            <td>Tellus Ltd</td>
                            <td><span class="pie">4,9</span></td>
                            <td>18%</td>
                            <td>Jul 22, 2013</td>
                        </tr>
                        <tr>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                            <td><span class="pie">6,9</span></td>
                            <td>40%</td>
                            <td>Jul 16, 2013</td>
                        </tr>
                        <tr>
                            <td>Gamma project</td>
                            <td>Anna Jordan</td>
                            <td>(016977) 0648</td>
                            <td>Tellus Ltd</td>
                            <td><span class="pie">4,9</span></td>
                            <td>18%</td>
                            <td>Jul 22, 2013</td>
                        </tr>
                        <tr>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                            <td><span class="pie">6,9</span></td>
                            <td>40%</td>
                            <td>Jul 16, 2013</td>
                        </tr>
                        <tr>
                            <td>Betha project</td>
                            <td>John Smith</td>
                            <td>0800 1111</td>
                            <td>Erat Volutpat</td>
                            <td><span class="pie">3,1</span></td>
                            <td>75%</td>
                            <td>Jul 18, 2013</td>
                        </tr>
                        <tr>
                            <td>Gamma project</td>
                            <td>Anna Jordan</td>
                            <td>(016977) 0648</td>
                            <td>Tellus Ltd</td>
                            <td><span class="pie">4,9</span></td>
                            <td>18%</td>
                            <td>Jul 22, 2013</td>
                        </tr>
                        <tr>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                            <td><span class="pie">6,9</span></td>
                            <td>40%</td>
                            <td>Jul 16, 2013</td>
                        </tr>
                        <tr>
                            <td>Gamma project</td>
                            <td>Anna Jordan</td>
                            <td>(016977) 0648</td>
                            <td>Tellus Ltd</td>
                            <td><span class="pie">4,9</span></td>
                            <td>18%</td>
                            <td>Jul 22, 2013</td>
                        </tr>
                        <tr>
                            <td>Betha project</td>
                            <td>John Smith</td>
                            <td>0800 1111</td>
                            <td>Erat Volutpat</td>
                            <td><span class="pie">3,1</span></td>
                            <td>75%</td>
                            <td>Jul 18, 2013</td>
                        </tr>
                        <tr>
                            <td>Gamma project</td>
                            <td>Anna Jordan</td>
                            <td>(016977) 0648</td>
                            <td>Tellus Ltd</td>
                            <td><span class="pie">4,9</span></td>
                            <td>18%</td>
                            <td>Jul 22, 2013</td>
                        </tr>
                        <tr>
                            <td>Alpha project</td>
                            <td>Alice Jackson</td>
                            <td>0500 780909</td>
                            <td>Nec Euismod In Company</td>
                            <td><span class="pie">6,9</span></td>
                            <td>40%</td>
                            <td>Jul 16, 2013</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

        </div>

    </div>
    </div>


    <!-- Footer-->


</div>



<!-- Vendor scripts -->
<?= Html::jsFile('@web/static/vendor/jquery/dist/jquery.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/jquery-ui/jquery-ui.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/slimScroll/jquery.slimscroll.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/bootstrap/dist/js/bootstrap.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/metisMenu/dist/metisMenu.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/iCheck/icheck.min.js'); ?>
<?= Html::jsFile('@web/static/vendor/sparkline/index.js'); ?>
<?= Html::jsFile('@web/static/vendor/fooTable/dist/footable.all.min.js'); ?>



<script>

    $(function () {

        // Initialize Example 1
        $('#example1').footable();



    });

</script>

</body>
</html>