<?php
namespace System\Http;

class Request
{

    private $url;
    private $baseUrl;

    /**
     * prepare URL
     * 
     * @return void
     *   */
    public function prepareUrl()
    {
        $script = dirname($this->server('SCRIPT_NAME'));
        
        $request_uri = $this->server('REQUEST_URI');
        if (strpos($request_uri,'?') !== false)
            list($request_uri,$query_string) = explode('?',$request_uri);

        $this->url = preg_replace('#^'.$script.'#','',$request_uri);

        $http = $this->server('REQUEST_SCHEME');
        $domain = $this->server('HTTP_HOST');
        $this->baseUrl = $http . '://'. $domain . $script . '/';
    }
    
    /**
     * Get current request method
     * 
     * @return string
     *   */
    public function method()
    {
        return $this->server('REQUEST_METHOD');
    }
    
     /**
     * Get value from _GET by the given key
     * 
     * @param string $key
     * @param string $default
     * @return mixed
     *   */
    public function get($key, $default = null)
    {
        return array_get($_GET, $key, $default);
    }

    /**
     * Get value from _POST by the given key
     * 
     * @param string $key
     * @param string $default
     * @return mixed
     *   */
    public function post($key, $default = null)
    {
        return array_get($_POST, $key, $default);
    }
    

    /**
     * Get Value From _SERVER by the given key
     * 
     * @param string $key
     * @param string $default
     * @return mixed
     *   */
    public function server($key, $default = null)
    {
        return array_get($_SERVER, $key, $default);
    }

    /**
     * Get only relative url (clean url)
     * 
     * @return string
     *   */
    public function url()
    {
        return $this->url;
    }

    /**
     * Get full url of the script
     * 
     * @return string
     *   */
    public function baseUrl()
    {
        return $this->baseUrl;
    }
    
}
