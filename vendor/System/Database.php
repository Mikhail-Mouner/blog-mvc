<?php
namespace System;

use PDO;
use PDOException;

class Database
{
    private $application;
    private static $connection;
    private $table;
    private $data = [];
    private $bindings = [];
    private $lastID;
    private $wheres = [];
    
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
            static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            static::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            static::$connection->exec('SET NAMES utf8');
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

    /**
     * Set the table name 
     * 
     * @param string $table
     * @return $this
     *   */
    public function table($table) {
        $this->table = $table;
        return $this;
    }

    /**
     * Set the table name 
     * 
     * @param string $table
     * @return $this
     *   */
    public function from($table) {
        return $this->table($table);
    }

    /**
     * Set WHERE clause
     * 
     * @param mixed $where
     * @return $this
     *   */
    public function where(...$bindings) {
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->wheres[] = $sql;
        return $this;
    }
    
    /**
     * Set the Data that will be stored in database table
     * 
     * @param mixed $key
     * @param mixed $value
     * @return $this
     *   */
    public function data($key, $value = null) {
        if (is_array($key)){
            $this->data = array_merge($this->data, $key);
            $this->addToBindings($key);
        }else {
            $this->data[$key] = $value;
            $this->addToBindings($value);
        }

        return $this;
    }
    
    /**
     * Insert the Data to database table
     * 
     * @return $this
     *   */
    public function insert($table = null) {
        if ( !is_null($table) )
            $this->table($table);

        $sql = "INSERT INTO ". $this->table ." SET ";

        $sql .= $this->setFields();

        $this->query($sql, $this->bindings);
        $this->lastID = $this->connection()->lastInsertId();
        return $this;
    }   
    
    /**
     * Update the Data to database table
     * 
     * @return $this
     *   */
    public function update($table = null) {
        if ( !is_null($table) )
            $this->table($table);

        $sql = "UPDATE ". $this->table ." SET ";

        $sql .= $this->setFields();

        if ( !is_null($this->where) )
            $sql .= ' WHERE '. implode('', $this->wheres);

        $this->query($sql, $this->bindings);
        return $this;
    }   
    
    /**
     * Add given value to biindings
     * 
     * @param mixed $value
     * @return void
     *   */
    private function addToBindings($value) {
        if ( is_array($value))
            $this->bindings[] = array_merge($this->bindings, $value);
        else
            $this->bindings[] = $value;
    }
    
    /**
     * Set field for insert and update
     * 
     * @return string
     *   */
    private function setFields() {
        $sql = '';
        foreach (array_keys($this->data) as $key) {
            $sql .= '`'.$key.'` = ? , ';
        }
        $sql = rtrim($sql,', ');
        return $sql;
    }
    
    /**
     * Get last insert id
     * 
     * @return int
     *   */
    public function lastID() {
        return $this->lastID;
    }
    
    /**
     * Execute the given sql statement
     * 
     * @param string $query
     * @return \PDOStatement
     *   */
    public function query(...$bindings) {
        $sql = array_shift($bindings);
        if (count($bindings) == 1 && is_array($bindings[0]))
            $bindings = $bindings[0];
        try{    
            $query =$this->connection()->prepare($sql);
            foreach ($bindings as $key => $value) {
                $query->bindValue($key+1, _e($value));
            }
            $query->execute();
        }catch (PDOException $e){
            die('Error in query: '.$e->getMessage());
        }

        return $query;
    }

}