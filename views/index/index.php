<?php
use yii\helpers\Html;
?>
<div class="normalheader transition small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5 class="font-light m-b-xs">
                选择游戏
            </h5>
        </div>
    </div>
</div>

<!-- Main Wrapper -->
<div class="content animate-panel">
    <?php
        foreach ($gameInfo as $k) {
          echo '<a href="/index/seldb?id='.$k['id'].'&alias='.$k['alias'].'" class="btn btn-success btn-lg btn-block active" role="button">'.$k['name'].'</a>';
        }
    ?>
<!-- 	<a href="/index/session" class="btn btn-success btn-lg btn-block active" role="button">大掌门</a>
	<a href="/index/session" class="btn btn-success btn-lg btn-block active" role="button">乱世曲</a> -->
 <!--   <button type="button" class="btn btn-info btn-lg btn-block">大掌门</button>

       <button type="button" class="btn btn-info btn-lg btn-block">乱世曲</button>   -->  

</div>




<!-- Footer-->

<!-- Vendor scripts -->



</body>
</html>