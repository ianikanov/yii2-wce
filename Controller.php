<?php

namespace ianikanov\wce;

use Yii;

/**
 * Embedded controller which performs required POST actions to support widgets.
 * Include into your controller map updating config:
 * ~~~php
 *   'controllerMap' => [
 *       'wce-embed' => '\ianikanov\wce\Controller',
 *   ],
 * ~~~
 * 
 * You can specify your class if needed which is inherited from the provided one.
 * When overriding make sure you invoke the parent action like this:
 * ~~~php
 * class YourEmbedController extends \ianikanov\wce\Controller {
 *     public function actionIndex()
 *     {
 *         return parent::actionIndex();
 *     }
 * }
 * ~~~
 * 
 * @author Ivan Anikanov
 */
class Controller extends \yii\web\Controller {
    
    public $controllerNamespace = '\app\widgets';
    
    public function actionIndex()
    {
        list($route, $params) = Yii::$app->request->resolve();
        $route = $params['action'];
        unset ($params['r']);
        unset ($params['action']);
        
        // double slashes or leading/ending slashes may cause substr problem
        $route = trim($route, '/');
        if (strpos($route, '//') !== false) {
            return false;
        }

        if (strpos($route, '/') !== false) {
            list($id, $route) = explode('/', $route, 2);
        } else {
            $id = $route;
            $route = '';
        }
        
        $className = preg_replace_callback('%-([a-z0-9_])%i', function ($matches) {
                return ucfirst($matches[1]);
            }, ucfirst($id)) . 'ControllerWidget';
        $className = ltrim($this->controllerNamespace . '\\' . $className, '\\');
        
        
        $result = forward_static_call([$className, 'widget'], [
            'action' => $route,
            'params' => $params,
        ]);
        
        $class = new \ReflectionClass($className);
        $messageNoContentError = $class->getStaticPropertyValue('messageNoContentError');
        $messageNoCallbackInfo = $class->getStaticPropertyValue('messageNoCallbackInfo');
        
        if ($result == "") {
            if ($messageNoContentError > '') Yii::$app->session->addFlash('error', $messageNoContentError);
        }
        elseif (isset($params['callback'])) {
            $this->redirect($params['callback']);
        } else {
            if ($messageNoCallbackInfo > '') Yii::$app->session->addFlash('info', $messageNoCallbackInfo);
            return $this->renderContent($result);
        }
    }
}
