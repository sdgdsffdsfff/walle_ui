<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use models\User;
use clients\ucenter\services\Common;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class SiteController extends BaseController
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 登陆
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->goHome();
        }
        //callback
        $callback = Url::toRoute('site/callback', true);
        $loginUrl = Common::loginUrl($callback);
        return $this->redirect($loginUrl);
    }

    /**
     * SSO登录回跳
     *
     * @return \yii\web\Response
     */
    public function actionCallback()
    {
        $token = Yii::$app->getRequest()->get('token');

        if (null === $token) {
            //TODO 跳转不合理
            $this->error403();
        }

        // 验证token
        $uid = Common::checkToken($token);

        if (!$uid) {
            $this->error403();
        }
        $uid = (int)$uid;
        $user = User::findIdentity($uid);
        if(!$user){
            $this->error403();
        }

        Yii::$app->getUser()->login($user);
        return $this->goHome();
    }

    /**
     * 登出
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();
        $callback = Url::toRoute('site/callback', true);
        $loginUrl = Common::loginUrl($callback);
        $logoutUrl = Common::logoutUrl($loginUrl);
        return $this->redirect($logoutUrl);
    }
    
    /**
     * 错误处理
     */
    public function actionError()
    {
        if(yii::$app->getErrorHandler()->exception instanceof NotFoundHttpException) 
        {
            $this->error404();
        } 
        else if(yii::$app->getErrorHandler()->exception instanceof ForbiddenHttpException) 
        {
            $this->ajaxError();
            $this->error403();
        } 
        else 
        {
            $this->error500();
        }
    }
    
    /**
     * ajax提示无权限
     * @return boolean
     */
    private function ajaxError()
    {
        if(!yii::$app->getRequest()->isAjax)
        {
            return false;
        }

        $this->newajaxReturn(self::STATUS_PERMIT, '无权限访问,请联系管理员!', '无权限访问,请联系管理员!');
    }
}
