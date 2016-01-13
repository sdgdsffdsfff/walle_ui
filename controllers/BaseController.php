<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Json;
use filters\PermissionFilter;
use yii\web\Response as Response;

/**
 * Class BaseController
 * @package admin\controllers
 */
class BaseController extends Controller
{
    const LAYOUT_LOGIN = 'login_main';

    const TPL_JUMP_SUCCESS = '../partial/success';
    const TPL_JUMP_ERROR = '../partial/error';
    const TPL_JUMP_ERROR_404 = '../partial/404';
    const TPL_JUMP_ERROR_500 = '../partial/500';
    const TPL_JUMP_ERROR_403 = '../partial/403';

    /**
     * 状态码
     */
    const STATUS_SUCCESS = 10000;  //成功
    const STATUS_FAILS = 99999;  //失败
    const STATUS_PERMIT = 40003;  //无权限
    
    public $roleOfUser = [];
    public $dataForMenu = [];
    public $dataForFunc = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['site'],
                        'actions' => ['login', 'callback', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'permission' => [
                'class' => PermissionFilter::className()
            ]
        ];
    }

    /**
     * 公共初始化函数
     */
    public function init()
    {
        if (Yii::$app->getUser()->getIdentity()) 
        {
            //获取当前用户所有角色
            $userRoles = Yii::$app->getUser()->getIdentity()->getUserRoles();
            
            $this->getView()->params['menuData'] = yii::$app->params['menuData'];
        }
    }
    
    /**
     * 跳转页
     *
     * @param string $tpl        模板页
     * @param string $msg        操作信息
     * @param string $url        跳转URL
     * @param int    $waitSecond 等待时长
     *
     * @return void
     */
    private function _jumpPage($tpl, $msg, $url, $waitSecond = 5)
    {
        $response = Yii::$app->getResponse();
        $response->content = $this->renderPartial($tpl, [
            'message' => $msg,
            'jumpUrl' => $url,
            'waitSecond' => $waitSecond
        ]);
        $response->send();

        if (YII_ENV_TEST) {
            die();
        } else {
            \yii::$app->end();
        }

    }

    /**
     * success
     *
     * @param string $msg        操作信息
     * @param string $url        跳转URL
     * @param int    $waitSecond 等待时长
     *
     * @return void
     */
    protected function success($msg, $url, $waitSecond = 5)
    {
       $this->_jumpPage(self::TPL_JUMP_SUCCESS, $msg, $url, $waitSecond);
    }

    /**
     * error
     *
     * @param string $msg        操作信息
     * @param string $url        跳转URL
     * @param int    $waitSecond 等待时长
     *
     * @return void
     */
    protected function error($msg, $url, $waitSecond = 3)
    {
        $this->_jumpPage(self::TPL_JUMP_ERROR, $msg, $url, $waitSecond);
    }

    /**
     * error 404
     *
     * @return void
     */
    protected function error404()
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(404);
        $response->content = $this->renderPartial(self::TPL_JUMP_ERROR_404);
        $response->send();

        if (YII_ENV_TEST) {
            die();
        } else {
            \yii::$app->end();
        }
    }

    /**
     * error 403
     *
     * @return void
     */
    protected function error403()
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(403);
        $response->content = $this->renderPartial(self::TPL_JUMP_ERROR_403);
        $response->send();

        if (YII_ENV_TEST) {
            die();
        } else {
            \yii::$app->end();
        }
    }

    /**
     * error 500
     *
     * @return void
     */
    protected function error500()
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(500);
        $response->content = $this->renderPartial(self::TPL_JUMP_ERROR_500);
        $response->send();

        if (YII_ENV_TEST) {
            die();
        } else {
            \yii::$app->end();
        }
    }

    /**
     * 统一ajax输出
     *
     * @param bool  $status 状态
     * @param mixed $data   数据
     *
     * return void
     */
    protected function ajaxReturn($status, $data, $description='')
    {
        echo Json::encode(['status' => (int)$status,'description'=>$description, 'data' => $data]);
        die;
    }

    /**
     * 新ajax输出(无权限提示,需此方法)
     * @param type $status
     * @param type $data
     * @param type $description
     * @param type $type
     */
    protected function newajaxReturn($status, $data, $description='', $type='JSON')
    {
        $response = Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;
        $response->data = array("status" => $status, "data" => $data, 'description' => $description);
        Yii::$app->end();
    }
}
