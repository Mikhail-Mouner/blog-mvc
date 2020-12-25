<?php
namespace System\View;

use System\Application;

class ViewFactory
{
    private $application;
    
    public function __construct(Application $app) {
        $this->application = $app;
    }

    /**
     * Render the given view path with the passed variables and generate new .......
     * 
     * @param string $viewPath
     * @param array $data
     * @return \System\View\ViewInterface
     *   */
    public function render($viewPath, array $data = [])
    {
        return new View($this->application->file , $viewPath, $data);
    }
}