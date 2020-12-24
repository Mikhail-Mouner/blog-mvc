<?php
namespace System;

class File
{   
    private $root;

    const DS = DIRECTORY_SEPARATOR;

    public function __construct($root)
    {
        $this->root = $root ;
    }
    
    /**
     * Determine wether the given file path exists
     * 
     * @param string $file
     * @return boolean
     *   */
    public function exists($file)
    {
        return file_exists($this->to($file));
    }
    
    /**
     * Require the given file
     * 
     * @param string $file
     * @return boolean
     *   */
    public function call($file)
    {
        require $this->to($file);
    }
    
    /**
     * Generate full path to the given path in vendor folder
     * 
     * @param string $path
     * @return string
     *   */
    public function toVendor($path)
    {
        return $this->to('vendor/'.$path);
    }
    
    /**
     * Generate full path to the given path
     * 
     * @param string $path
     * @return string
     *   */
    public function to($path)
    {
        $ds = self::DS;
        return $this->root . $ds . str_replace(['/','\\'],$ds,$path) ;
    }

}