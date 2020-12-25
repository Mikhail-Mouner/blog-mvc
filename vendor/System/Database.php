<?php
namespace System;

use PDO;
use PDOException;

class Database
{
    private $application;
    private static $connection;
    
    public function __construct(Application $app) {
        $this->application = $app;
        if ( !$this->isConnected() )
            $this->connect();
    }
    
    /**
     * Determine if there is any connection to data
     * 
     * @return boolean
     *   */
    private function isConnected() {
        return static::$connection instanceof PDO;
    }

    /**
     * Connect to Database
     * 
     * @param string $header
     * @param mixed $value
     * @return void
     *   */
    public function connect() {
        $connectionData = $this->application->file->call('config.php');
        extract($connectionData);

        try{
            static::$connection = new PDO("mysql:host=$server;dbname=$dbname",$dbuser,$dbpass);
        }catch (PDOException $e){
            die('Not connection '.$e->getMessage());
        }
    }

    /**
     * Get Database Connection object PDO object
     * 
     * @return \PDO
     *   */
    public function connection() {
        return static::$connection;
    }


}