<?php 
namespace System;

class Route
{
    private $application;
    private $routes = [];
    private $notFound;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }
    
    /**
     * Add new Route
     * 
     * @param string $url
     * @param string $action
     * @param string $requestMethod
     * @return void
     */
    public function add($url, $action, $requestMethod = "GET")
    {
        $route = [
            'url'     => $url,
            'pattern' => $this->generatePattern($url),
            'action'  => $this->getAction($action),
            'method'  => strtoupper($requestMethod),
        ];
        $this->routes[] = $route;
    }

    /**
     * Generate regex pattern for the given url
     * 
     * @param string $url
     * @return string
     */
    public function generatePattern($url)
    {
        $pattern  = '#^';
        $pattern .= str_replace([':text',':id'],['([a-zA-Z0-9-]+)','(\d+)'],$url);
        $pattern .= '$#';
        
        return $pattern;
    }

    /**
     * Get action
     * 
     * @param string $url
     * @return string
     */
    private function getAction($action)
    {
        $action = str_replace('/','\\',$action);
        return strpos($action,'@') !== false ? $action : $action.'@index';
    }

    /**
     * Set not found url
     * 
     * @param string $url
     * @return void
     */
    public function notFound($url)
    {
        $this->notFound = $url;
    }

    /**
     * Get proper route
     * 
     * @return mixed
     */
    public function getProperRoute()
    {
        foreach ($this->routes as $route) {
            if ($this->isMatching($route['pattern'])) {
                $arguments = $this->getArgumentsFor($route['pattern']);
                list($controller,$method) = explode('@',$route['action']);
                return [$controller, $method, $arguments];
            }
        }
    }

    /**
     * Determine if the given pattern matches current request url
     * 
     * @param string $pattern
     * @return boolean
     */
    private function isMatching($pattern)
    {
        return preg_match($pattern,$this->application->request->url());
    }

    /**
     * Get arguments from the current request url based on the given pattern
     * 
     * @param string $pattern
     * @return mixed
     */
    private function getArgumentsFor($pattern)
    {
        preg_match($pattern,$this->application->request->url(),$matches);
        array_shift($matches);
        return $matches;
    }

}