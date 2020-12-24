<?php
namespace System;

class Loader
{
    private $application;
    private $controllers = [];
    private $models = [];

    public function __construct(Application $app) {
        $this->application = $app;
    }
    
    /**
     * Call the given controller with the given method
     * and pass the given arguments to controller method
     * 
     * @param string $controller
     * @param string $method
     * @param array $arguments
     * @return mixed
     *   */
    public function action($controller, $method, array $arguments)
    {
        $object = $this->controller($controller);
        return call_user_func([$object, $method] ,$arguments);
    }
    
    /**
     * Call the given controller
     * 
     * @param string $controller
     * @return object
     *   */
    public function controller($controller)
    {
        $controller = $this->getControllerName($controller);
        if ( ! $this->hasController($controller) )
            $this->addController($controller);
    
        return $this->getController($controller);
    }
    
    /**
     * Determine if the given class|controller exists
     * in the controllers container
     * 
     * @param string $controller
     * @return boolean
     *   */
    private function hasController($controller)
    {
        return array_key_exists($controller,$this->controllers);
    }
    
    /**
     * Create new object for the given controller and store it
     * in the controllers container
     * 
     * @param string $controller
     * @return void
     *   */
    private function addController($controller)
    {
        $object = new $controller($this->application);
        $this->controllers[$controller] = $object;
    }
    
    /**
     * Get the controller object
     * 
     * @param string $controller
     * @return object
     *   */
    private function getController($controller)
    {
        return $this->controllers[$controller];
    }
    
    /**
     * Get the full class name for the given controller
     * 
     * @param string $controller
     * @return string
     *   */
    private function getControllerName($controller)
    {
        return 'App\\Controllers\\' . $controller . 'Controller';
    }
    
    /**
     * Call the given model
     * 
     * @param string $model
     * @return object
     *   */
    public function model($model)
    {
    }
    
    /**
     * Determine if the given model exists
     * in the controllers container
     * 
     * @param string $model
     * @return boolean
     *   */
    private function hasModel($model)
    {
    }
    
    /**
     * Create new object for the given model and store it
     * in the models container
     * 
     * @param string $model
     * @return void
     *   */
    private function addModel($model)
    {
    }
    
    /**
     * Get the model object
     * 
     * @param string $model
     * @return object
     *   */
    private function getModel($model)
    {
    }

}