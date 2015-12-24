<?php
namespace app\assets;
/**
 * Description of PluginsAsset
 * 资源包--管理视图所用到的css和javascript文件
 * @author zhaolu@playcrab.com
 */
use yii\web\AssetBundle;

class PluginsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    /**
     * css文件
     * @var type 
     */
    public $css = [
        'static/plugins/fontawesome/css/font-awesome.css',
        'static/plugins/metisMenu/dist/metisMenu.css',
        'static/plugins/animate.css/animate.css',
        'static/plugins/bootstrap/dist/css/bootstrap.css',
        'static/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'static/fonts/pe-icon-7-stroke/css/helper.css',
        'static/styles/style.css',
    ];
    
    /**
     * javascript文件
     * @var type 
     */
    public $js = [
        'static/plugins/jquery/dist/jquery.min.js',
        'static/plugins/jquery-ui/jquery-ui.min.js',
        'static/plugins/slimScroll/jquery.slimscroll.min.js',
        'static/plugins/bootstrap/dist/js/bootstrap.min.js',
        'static/plugins/jquery-flot/jquery.flot.js',
        'static/plugins/jquery-flot/jquery.flot.resize.js',
        'static/plugins/jquery-flot/jquery.flot.pie.js',
        'static/plugins/flot.curvedlines/curvedLines.js',
        'static/plugins/jquery.flot.spline/index.js',
        'static/plugins/metisMenu/dist/metisMenu.min.js',
        'static/plugins/iCheck/icheck.min.js',
        'static/plugins/peity/jquery.peity.min.js',
        'static/plugins/sparkline/index.js',
    ];
}
