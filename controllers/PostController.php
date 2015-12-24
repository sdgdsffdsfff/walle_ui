<?php
namespace app\controllers;
/**
 * Description of PostController
 *
 * @author playcrab
 */
use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex()
    {
        //return 'test yii2';
        return $this->render('index');
    }
}
