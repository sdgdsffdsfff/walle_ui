<?php
use yii\helpers\Html;
?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                客户端更新包状态
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
                            <label for="exampleInputName2">发布任务ID：</label>
                            <input type="text" class="form-control" name="id" value="<?php echo $job_id; ?>" placeholder="版本号" style="width:120px; margin-right: 20px;" />
                        </div>
     
   
                        <button type="submit" class="btn btn-warning" style="margin-left: 20px;">查询</button>
                    </form>
                </div>
                
                <div class="table-responsive" style="background: #fff;border: 1px solid #e4e5e7;border-radius: 2px;padding: 20px;">
                  
                    <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-toggle="true">源版本号</th>
                                <th>目标版本号</th>
                                 <th>客户端更新包url</th>
                                <th>http响应状态</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 

                                if($data){
                                    foreach ($data as $key => $value) {
                                       
                                        if($value['filename'])
                                        {
                                            foreach ($value['filename'] as $k => $v) {
                                                echo "<tr>";
                                                echo "<td><a style='text-decoration:underline' href='/version/version-detail?version_id=".$value['from_version']."' >".$value['from_version']."</a></td>";
                                                echo "<td><a style='text-decoration:underline' href='/version/version-detail?version_id=".$value['to_version']."' >".$value['to_version']."</a></td>";
                                                //echo "<td><a style='text-decoration:underline' href='/version/version-detail?version_id=".$value['to_version']."‘ >".$value['to_version']."</a></td>";
                                                echo "<td><a style='text-decoration:underline' href='".$value['url'].$v."' target='_blank'>".$value['url'].$v."</a></td>";
                                                echo "<td><img src='/static/images/loading2.gif' /></td>";
                                                echo "</tr>";
                                            }
                                           
                                        }
                                        
                                       
                                        
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
 $ (function ()
    {
        $("table tr:gt(0)").each(function(i){
           
            $(this).children("td").each(function(j){
                if(j==2){
                    var td=$(this).next('td');
                    var post = {url_info : $(this).text()};
                    $.ajax({
                        type:'post',
                        url:'/packagestatus/request',
                        data:post,
                        dataType:'json',
                    }).done(function(data){
                      
                       td.text(data.status);
                    });
                }
                });
                   
                
            });
    })
</script>