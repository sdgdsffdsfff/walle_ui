<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace filters;

use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\ForbiddenHttpException;

/**
 * VerbFilter Class

 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class PermissionFilter extends Behavior
{
    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws MethodNotAllowedHttpException when the request method is not allowed.
     */
    public function beforeAction($event)
    {
        if (Yii::$app->getUser()->getIdentity()) 
        {
            $controller = Yii::$app->controller->id;
            $action = $event->action->id;

            $permission = Yii::$app->getUser()->getIdentity()->getUserFunctions();
            
            //通用权限
            $common_sec = ['index/index', 'index/seldb','site/logout','task/jpublish','error/config-error','error/connection-error'];
            if(!empty($permission) && is_array($permission))
            {
                //将通用权限加到数组中
                $userFunctions = array_merge($common_sec, $permission);
            }
            else
            {
                $userFunctions = $common_sec;
            }

            yii::$app->getView()->params['requestUrl'] = $userFunctions;
            
            $cAction = ($controller . '/' . $action);
            $errorAction = yii::$app->getErrorHandler()->errorAction;
            if ($cAction !== $errorAction) 
            {
                if (!in_array($cAction, $userFunctions)) 
                {
                    //throw new MethodNotAllowedHttpException('Method Not Allowed. ');
                    throw new ForbiddenHttpException('你没有权限访问,请联系管理员!');
                }
            }
        }

        return $event->isValid;
    }
}