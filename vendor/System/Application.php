<?php
namespace System;

class Application
{

    private $container = [] ;

    public function __construct(File $file)
    {
        $this->share('file',$file);
        $this->registerClasses();
        $this->loaderHelper();
    }

    /**
     * Register Classes in splauto load register
     * 
     * @return void
     *   */
    private function registerClasses()
    {
        spl_autoload_register([$this,'load']);
    }
    
    /**
     * Load Class through autoloading
     * 
     * @param string $class
     * @return void
     *   */
    public function load($class)
    {
        if (strpos($class,'App') === 0)
            $file = $this->file->to($class.'.php');
        else
            $file = $this->file->toVendor($class.'.php');
        
        if ( $this->file->exists($file) ) 
            $this->file->require($file);
    
    }
    
    /**
     * Load Helpers File
     * 
     * @return void
     *   */
    public function loaderHelper()
    {
        $file = $this->file->toVendor('helpers.php');
        $this->file->require($file);
    }

    
    /**
     * Get Shared value dynamically
     * 
     * @param string $key
     * @return mixed
     *   */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Get Shared value
     * 
     * @param string $key
     * @return mixed
     *   */
    public function get($key)
    {
        if (!$this->isSharing($key)){
            if ($this->isCoreAlias($key))
                $this->share($key,$this->createNewCoreObject($key));
            else
                die('<b>' . $key . '</b>' . ' Not Found In Application' );
        }


        return $this->container[$key];
    }

    /**
     * Determine if the given key is shared through Application
     * 
     * @param string $key
     * @return boolean
     *   */
    public function isSharing($key)
    {
        return isset($this->container[$key]);
    }

    /**
     * Determine if the given key is in core classes
     * 
     * @param string $key
     * @return boolean
     *   */
    private function isCoreAlias($alias)
    {
        $core = $this->coreClasses();
        return isset($core[$alias]);
    }

    /**
     * Create new object for the core class based on the given alias
     * 
     * @param string $key
     * @param string $value
     * @return mixed
     *   */
    private function createNewCoreObject($alias)
    {
        $core = $this->coreClasses();
        $object = $core[$alias];
        return new $object($this);
    }

    /**
     * Share hte given key|value through Application
     * 
     * @param string $key
     * @param string $value
     * @return mixed
     *   */
    public function share($key, $var)
    {
        $this->container[$key] = $var ;
    }

    
    /**
     * Get All core Classes with its aliases through Application
     * 
     * @return mixed
     *   */
    private function coreClasses()
    {
        return [
            'request'    =>  'System\\Http\\Request',
            'response'   =>  'System\\Http\\Response',
            'session'    =>  'System\\Session',
            'cookie'     =>  'System\\Cookie',
            'load'   =>  'System\\Loader',
            'html'   =>  'System\\Html',
            'db'   =>  'System\\Database',
            'view'   =>  'System\\View\\ViewFactory'
        ];
    }
    
    /**
     * RUN APPLICATION
     * 
     * @return void
     *   */
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
    }




    
}