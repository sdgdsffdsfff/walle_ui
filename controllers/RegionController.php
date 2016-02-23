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
use app\models\RegionConfig;

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
