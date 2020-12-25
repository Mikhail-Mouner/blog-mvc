<?php
namespace System\View;

use System\File;

class View implements ViewInterface
{
    private $file;
    private $viewPath;
    private $data = [];
    private $output;

    public function __construct(File $file, $viewPath, array $data) {
        $this->file = $file;
        $this->perparePath($viewPath);
        $this->data = $data;
    }

    /**
     * Prepare view path
     * 
     * @param string $viewPath
     * @return string
     *   */
    private function perparePath($viewPath)
    {
        $relativePath = 'App/Views/' . $viewPath . '.php';
        $this->viewPath = $this->file->to( $relativePath );
        if ( !$this->viewFileExists($relativePath) )
            die( 'View File :' . '<b>' . '('.$viewPath.')'. '</b>' .' doesn\'t exists in project directory');
        
    }

    /**
     * Determine if the view file exsits
     * 
     * @param string $relativePath
     * @return boolean
     *   */
    private function viewFileExists($relativePath)
    {
        return $this->file->exists($relativePath);
    }

    /**
     * { @inheritDoc }
     *   */
    public function getOutput()
    {
        if (is_null($this->output)) {
            ob_start();
            extract($this->data);
            require $this->viewPath;
            $this->output = ob_get_clean();
        }
        return $this->output;
    }

    
    /**
     * { @inheritDoc }
     *   */
    public function __toString()
    {
        return $this->getOutput();       
    }
}