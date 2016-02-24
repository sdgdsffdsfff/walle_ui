<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use app\controllers\BaseController;
use app\models\Version;
use app\models\Platform;
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Clientpackage;


class UpgradepathController extends BaseController
{
	
    public function actionList()
    {	
       $data=UpgradePath::find()->asArray()->all();
       return $this->render('list',array('data'=>$data));
    }

   public function actionEdit()
    {   
       return $this->render('edit');
    }
     public function actionCopy()
    {   
       return $this->render('copy');
    }
}
