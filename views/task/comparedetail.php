<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                任务对比详情
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4">
                    <button id="select_data_btn" class="btn w-xs btn-warning2" style="margin-left: 160px; margin-bottom:-30px;">显示/隐藏相同项</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="content">
                <div class="hpanel horange">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="job_table" class="table table-bordered table-striped" cellpadding="1" cellspacing="1">
                                <thead>
                                <tr>
                                    <th>类型</th>
                                    <th>参数名称</th>
                                    <?php if($jobConfigs){ ?>
                                        <?php for($i = 0;$i < count($jobConfigs); $i++){ ?>
                                        <th>参数取值</th>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <th>参数取值</th>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <?php if($jobConfigs){ ?>
                                <tbody>
                                    <?php foreach($fieldsConfig as $field){ ?>
                                    <tr>
                                        <td><?= $field['type']; ?></td>
                                        <td><?= $field['name']; ?></td>
                                        <?php foreach($jobConfigs as $key => $data){ ?>
                                            <?php if(isset($field['value'][$key]) && !empty($field['value'][$key])){ ?>
                                            <td><?= $field['value'][$key]; ?></td>
                                            <?php }else{ ?>
                                            <td></td>
                                            <?php } ?>
                                        <?php } ?>
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
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#select_data_btn').bind('click', function(){
            var boolean;
            $("#job_table tbody tr").each(function(trindex, tritem){   //遍历每一行
                var txtVal = '';
                $(tritem).find('td:gt(1)').each(function(tdindex, tditem){
                    if(tdindex == 0)
                    {
                        txtVal = $.trim($(tditem).text());
                        return true;
                    }
                    return boolean = filterElement(txtVal, tdindex, tditem);
                });
                //console.log(trindex+'---->'+boolean);
                //隐藏相同行
                if(boolean)
                {
                    $(tritem).toggle();
                }
            });
        });
    });
    
    function filterElement(txtVal, tdindex, tditem)
    {
        if(txtVal != $.trim($(tditem).text()))
        {
            return false;
        }

        return true;
    }
</script>