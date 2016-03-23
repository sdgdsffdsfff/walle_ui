<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                打包机配置列表
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
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">ID</th>
                                <th>主机名</th>
                                <th>是否启用</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <?php if(!empty($allData)){ ?>
                        <tbody>
                            <?php foreach($allData as $worker){ ?>
                            <tr>
                                <td><?= $worker['id']; ?></td>
                                <td><?= $worker['hostname']; ?></td>
                                     <?php if($worker['disable']==0){
                                     echo '<td style="color:#66CD00">是</td>';
                                   }else{
                                     echo '<td style="color:red;">否</td>';
                                 }
                                 ?>
                                <td align="center">
                                    <a href="/worker/edit?worker_id=<?= $worker['id']; ?>" class="btn btn-info">编辑</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>