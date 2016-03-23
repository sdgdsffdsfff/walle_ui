<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                参数配置列表
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4">
                    <a href="/parameter/create" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel hgreen">
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
<!--                    <div style="float:right">
                        <?php //echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div> 
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php //echo $pageCount;?> /总记录数：<?php //echo $totalCount;?></div>-->
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>参数名称</th>
                                <th>参数类型</th>
                                <th>描述信息</th>
                                <th>默认值</th>
                                <th>是否启用</th>
                                <th>备选项</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <?php if(!empty($allParameter)){ ?>
                        <tbody>
                            <?php foreach ($allParameter as $parameter){ ?>
                            <tr>
                                <td><?= $parameter['id']; ?></td>
                                <td><?= $parameter['name']; ?></td>
                                <td><?= $parameter['value_type']; ?></td>
                                <td><?= $parameter['description']; ?></td>
                                <td><?= $parameter['default_value']; ?></td>
                                 <?php if($parameter['disable']==0){
                                     echo '<td style="color:#66CD00">是</td>';
                                   }else{
                                     echo '<td style="color:red;">否</td>';
                                 }
                                 ?>
                          
                                <td><?= $parameter['options']; ?></td>
                                <td align="center">
                                    <a href="/parameter/edit?parameter_id=<?= $parameter['id']; ?>" class="btn btn-info">编辑</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } ?>
                    </table>
<!--                    <div style="float:right">
                        <?php //echo LinkPager::widget(['pagination' => $pages]); ?>
                    </div> 
                    <div style="float:left;display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;" >总页数：<?php //echo $pageCount;?> /总记录数：<?php //echo $totalCount;?></div>-->
                </div>
            </div>
        </div>
    </div>
</div>