<?php
namespace System;

class Url
{
    protected $application;
    
    public function __construct(Application $app) {
        $this->application = $app;
    }

    /**
     * Generate Full Link For The Given Path
     * 
     * @param string $path
     * @return string
     */
    public function link($path)
    {
        return $this->application->request->baseUrl() . trim($path,'/');
    }

    /**
     * Redirect To The Given Path
     * 
     * @param string $path
     */
    public function redirect($path)
    {
        header('location:' . $this->link($path) );
        exit();
    }

}
