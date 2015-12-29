<?php
/**
* detail.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2015 www.playcrab.com
* 
* Changelog:
* 2015-12-28 - created
* 
*/
?>
<div class="content animate-panel">

<div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">任务参数</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">任务状态</a></li>
                <button class="btn btn-default col-lg-offset-9" onclick="stoptask()">终止任务</button>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <p>tab 1 tab 1 test test tesetsdfsadfasfdasdfasf</p>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <p>tab 2 tab 2 tab 2 test test tesetsdfsadfasfdasdfasf</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<script type="text/javascript">
function stoptask() {
    alert("test stop task");
}
</script>
