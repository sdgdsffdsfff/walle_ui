<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\controllers\BaseController;
use app\models\Version;
use app\models\Platform;
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Clientpackage;


class RegionController extends BaseController
{
    
    public function actionList()
    {   
       return $this->render('list');
    }

   public function actionEdit()
    {   
       return $this->render('edit');
    }


class RegionController extends BaseController
{
    /**
     * 发行地区配置列表
     */
    public function actionConfigList()
    {
        return $this->render('configlist');
    }

}
