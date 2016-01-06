<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use models\User;
use clients\ucenter\services\Common;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
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
}
