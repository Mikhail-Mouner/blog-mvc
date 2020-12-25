<?php
namespace System\Http;

use System\Application;

class Response
{
    private $application;
    private $headers = [];
    private $contant = '';
    
    public function __construct(Application $app) {
        $this->application = $app;
    }
    
    
    /**
     * Set the response output
     * 
     * @param string $contant
     * @return void
     *   */
    public function setOutput($contant)
    {
        $this->contant = $contant;
    }
    
    /**
     * Set the response header
     * 
     * @param string $header
     * @param mixed $value
     * @return void
     *   */
    public function setHeader($header ,$value)
    {
        $this->headers[$header] = $value;
    }
    
    /**
     * Send the response headers and Content
     * 
     * @return void
     *   */
    public function send()
    {
        $this->sendHeaders();
        $this->sendOutput();
    }
    
    /**
     * Send the response header
     * 
     * @return void
     *   */
    public function sendHeaders()
    {
        foreach ($this->headers as $header => $value) {
            header($header.':'.$value);
        }
    }

    /**
     * Send the response output
     * 
     * @return void
     *   */
    public function sendOutput()
    {
        echo $this->contant;
    }

}