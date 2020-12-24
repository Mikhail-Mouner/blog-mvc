<?php 
namespace System;

abstract class Controller
{
    private $application;
    
    public function __construct(Application $app) {
        $this->application = $app;
    }

    /**
     * Call shared apllication object dynameically
     * 
     * @param string $key
     * @return mixed
     *   */
    public function __get($key)
    {
        return $this->application->get($key);
    }
}