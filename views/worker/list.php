<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                查看Worker配置
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4">
                    <a href="/worker/create" class="btn w-xs btn-success" style="margin-bottom: 10px;">新增</a>
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
                                <th>主机名</th>
                                <th>是否禁用</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>deploy1.walle.playcrab-inc.com</td>
                                <td>是</td>
                                <td>
                                    <a href="/worker/edit" class="btn btn-info">编辑</a>
                                    <a href="/worker/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>deploy2.walle.playcrab-inc.com</td>
                                <td>是</td>
                                <td>
                                    <a href="/worker/edit" class="btn btn-info">编辑</a>
                                    <a href="/worker/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>deploy3.walle.playcrab-inc.com</td>
                                <td>是</td>
                                <td>
                                    <a href="/worker/edit" class="btn btn-info">编辑</a>
                                    <a href="/worker/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>172.16.30.17</td>
                                <td>否</td>
                                <td>
                                    <a href="/worker/edit" class="btn btn-info">编辑</a>
                                    <a href="/worker/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                        </tbody>
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