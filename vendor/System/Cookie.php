<?php
namespace System;

class Cookie
{
    private $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    
    /**
     * Get value from cookie by the given key
     * 
     * @param string $key
     * @return mixed
     *   */
    public function get($key, $default = NULL)
    {
        return array_get($_COOKIE, $key, $default);
    }
    
    /**
     * Get all value from cookie
     * 
     * @return mixed
     *   */
    public function all()
    {
        return $_COOKIE;
    }
    
    /**
     * Set new value to cookie
     * 
     * @param string $key
     * @param mixed $value
     * @param int $hours
     * @return void
     *   */
    public function set($key ,$value, $hours = 1800)
    {
        setcookie($key, $value, time() + $hours * 3600, '', '', false, true);
    }
    
    
    /**
     * Remove the given key from cookie
     * 
     * @param string $key
     * @return void
     *   */
    public function remove($key)
    {
        setcookie($key, NULL, -1);
        unset($_COOKIE[$key]);
    }
    
    /**
     * Destroy all cookie
     * 
     * @return void
     *   */
    public function destroy()
    {
        foreach (array_keys($this->all()) as $key) {
            $this->remove($key);
        }
        unset($_COOKIE[$key]);
    }
    
    /**
     * Determine if the cookie has value by given key
     * 
     * @param string $key
     * @return boolean
     *   */
    public function has($key)
    {
        return isset($_COOKIE[$key]);
    }
    

}