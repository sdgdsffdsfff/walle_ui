<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                发布任务对比
            </h5>
        </div>
    </div>
</div>

<div class="content animate-panel">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="hpanel">
                <div class="panel-heading">
                    待对比任务列表
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="table-responsive">
                            <table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>任务ID</th>
                                        <th>版本号</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>197</td>
                                        <td>133</td>
                                    </tr>
                                    <tr>
                                        <td>206</td>
                                        <td>136</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group" style="margin-top: -20px; color: red;">
                            <span class="col-md-8" style="margin-left: 5px;">(注: 最多可添加5个)</span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" style="margin-left: -10px;">任务ID: </label>
                            <div class="col-sm-4" style="margin-left: -16px;">
                                <input type="text" placeholder="任务ID" class="form-control" id="task_id" name="task_id" />
                            </div>
                            <span class="input-group-btn" style="right: -16px;">
                                <input type="button" id="search_btn" name="search_btn" class="btn w-xs btn-success" value="添加至待对比列表" onclick="javascript:getVersion();" />
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="col-xs-6 col-md-4"></div>
                <div class="col-xs-6 col-md-4">
                    <a href="/task/compare-detail" class="btn w-xs btn-success" style="margin-left: 126px;">任务对比</a>
                </div>
            </div>
        </div>
    </div>
</div>
