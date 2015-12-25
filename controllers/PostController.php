<?php
namespace app\controllers;
/**
 * Description of PostController
 *
 * @author playcrab
 */
use yii;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex()
    {
        //return 'test yii2';
        $params = yii::$app->getRequest()->get();
        
        return $this->render('index');
    }
}
