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


class DeploymentController extends BaseController
{
    
    public function actionList()
    {   
       return $this->render('list');
    }

   public function actionEdit()
    {   
       return $this->render('edit');
    }

    /**
     * 部署位置配置列表
     */
    public function actionConfigList()
    {
        return $this->render('configList');
    }

    /**
     * 编辑部署位置
     */
    public function actionConfigEdit()
    {
        return $this->render('configEdit');
    }
}
