<?php
namespace System;

abstract class Model
{
    protected $application;
    protected $table;

    public function __construct(Application $app) {
        $this->application = $app;
    }
    
    public function __get($key)
    {
        return $this->application->get($key);
    }
    
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->application->db,$method],$arguments);
    }
    
    public function all()
    {
        return $this->fetchAll($this->table);
    }
    
    public function get($id)
    {
        return $this->where('id = ?',$id)->fetch($this->table);
    }
}