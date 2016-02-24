<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                查看Parameter配置
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
                                <th>备选项</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>log_level</td>
                                <td>enum</td>
                                <td>walle日志级别</td>
                                <td>DEBUG</td>
                                <td>DEBUG,INFO,WARNNING,ERROR</td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>vms_url</td>
                                <td>string</td>
                                <td>客户端版本更新地址</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>build_small_package</td>
                                <td>bool</td>
                                <td>是否是不带资源安装包</td>
                                <td>false</td>
                                <td>true,false</td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>backend_source_path</td>
                                <td>string</td>
                                <td>后端源代码路径</td>
                                <td>/data/work/path/www</td>
                                <td></td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>log_level</td>
                                <td>enum</td>
                                <td>walle日志级别</td>
                                <td>DEBUG</td>
                                <td>DEBUG,INFO,WARNNING,ERROR</td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>log_level</td>
                                <td>enum</td>
                                <td>walle日志级别</td>
                                <td>DEBUG</td>
                                <td>DEBUG,INFO,WARNNING,ERROR</td>
                                <td>
                                    <a href="/parameter/edit" class="btn btn-info">编辑</a>
                                    <a href="/parameter/delete" class="btn btn-danger">删除</a>
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