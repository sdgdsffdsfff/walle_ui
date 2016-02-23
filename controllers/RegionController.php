<?php
namespace app\controllers;
/**
* RegionController.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2016 www.playcrab.com
* 
* Changelog:
* 2016-02-22 - created
* 
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
use app\models\RegionConfig;


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

    /**
     * 发行地区配置列表
     */
    public function actionConfigList()
    {
        return $this->render('configlist');
    }

    /**
     * 编辑和新增发行地区配置
     */
    public function actionConfigEdit()
    {
        return $this->render('configedit');
    }

}
