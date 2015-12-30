<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii\web\Controller;

class IndexController extends Controller
{
	public $layout = "vms_index";
    public function actionIndex()
    {
        return $this->render('index');
    }
}
