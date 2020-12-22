<?php
namespace System;

class Session
{
    private $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    
    /**
     * Start Session
     * 
     * @return void
     *   */
    public function start()
    {
        ini_set('session.use_only_cookies',1);
        if (!session_id())
            session_start();
    }

    /**
     * Get value from session by the given key
     * 
     * @param string $key
     * @return mixed
     *   */
    public function get($key, $default = NULL)
    {
        return array_get($_SESSION, $key, $default);
    }
    
    /**
     * Get all value from session
     * 
     * @return mixed
     *   */
    public function all()
    {
        return $_SESSION;
    }
    
    /**
     * Set new value to session
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     *   */
    public function set($key ,$value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get value from session by the given key then remove it
     * 
     * @param string $key
     * @return mixed
     *   */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }
    
    /**
     * Remove the given key from session
     * 
     * @param string $key
     * @return void
     *   */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
    
    /**
     * Destroy all session
     * 
     * @return void
     *   */
    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }
    
    /**
     * Determine if the session has value by given key
     * 
     * @param string $key
     * @return boolean
     *   */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
    

}