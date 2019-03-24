<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ianikanov\wce;

use Yii;
use ReflectionClass;
use yii\base\Action;

/**
 * Description of Widget
 *
 * @author aniki
 */
class Widget extends \yii\base\Widget {
    /**
     * Controller action string, f.e. post/index
     * Does not support modules
     * @var string set by widget caller
     */
    public $action;
    /**
     * List of parameters to call in controller
     * @var Array set by widget caller
     */
    public $params;
    
    /**
     * View path
     * @var string default = controllerID
     */
    public $path;
    /**
     * Route to embedded controller as it is defined in controllerMap in config
     * @var string default = '/wce-embed'
     */
    public $embeddedControllerRoute = '/wce-embed';
    /**
     * Parameter name to pass embedded controller route
     * @var type default = 'embeddedController'
     */
    public $embeddedControllerRouteName = 'embeddedController';
    /**
     * Error message displayed when controller operation return no content, for example when declined by action filter.
     * @var string set to empty to suppress the message 
     */
    public static $messageNoContentError = 'Operation returned no content';
    /**
     * Info message displayed when controller operation returned content, but no callback was defined.
     * The default action is to display this content with info message.
     * @var string set to empty to suppress the message
     */
    public static $messageNoCallbackInfo = 'Operation succeeded, but no callback was defined';
    
    public function init()
    {
        parent::init();
    }
    
    public function getViewPath() {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()) . '/views/' . $this->path . '/';
    }
    
    public function run()
    {
        $call = 'action'.ucfirst($this->action);
        $action = new Action($this->action, $this);
        if (!isset($this->params)) $this->params = [];
        if ($this->beforeAction($action))  {
            $result = call_user_func_array([$this, $call], $this->params);
            return $this->afterAction($action, $result);
        } else {
            return null;
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function render($view, $params = array()) {
        $params[$this->embeddedControllerRouteName] = $this->embeddedControllerRoute;
        return parent::render($view, $params);
    }
    
    /**
     * {@inheritDoc}
     */
    public function renderFile($file, $params = array()) {
        $params[$this->embeddedControllerRouteName] = $this->embeddedControllerRoute;
        return parent::renderFile($file, $params);
    }
    
    /**
     * @event ActionEvent an event raised right before executing a controller action.
     * You may set [[ActionEvent::isValid]] to be false to cancel the action execution.
     */
    const EVENT_BEFORE_ACTION = 'beforeAction';
    /**
     * @event ActionEvent an event raised right after executing a controller action.
     */
    const EVENT_AFTER_ACTION = 'afterAction';
    
    private function beforeAction($action)
    {
        $event = new \yii\base\ActionEvent($action);
        $this->trigger(self::EVENT_BEFORE_ACTION, $event);
        return $event->isValid;
    }
    private function afterAction($action, $result)
    {
        $event = new \yii\base\ActionEvent($action);
        $event->result = $result;
        $this->trigger(self::EVENT_AFTER_ACTION, $event);
        return $event->result;
    }
}
