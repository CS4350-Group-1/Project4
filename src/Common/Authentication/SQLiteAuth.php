<?php

namespace Common\Authentication;
//require 'IAuthentication.php';
use PDO;

class SQLiteAuth implements IAuthentication
{
    public function __construct($username, $password)
    {        
        $this->username=$username;
        $this->password=$password;
        //$path = 'sqlite::'+ realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'SQLitetest.sqlite');
        try
        {
            $this->conn = new PDO('sqlite:../data/SQLitetest.sqlite');
            //$this->conn = new PDO($path);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'ERROR: ' .$e->getMessage();
        }
    }
    
    public function authenticateA($authKey)
    {
        //gettting an error about missing authkey right now  not sure why
        $data=$this->conn->query('SELECT AuthKey FROM AuthK WHERE AuthKey= '.$this->conn->quote($authKey));
//        echo var_dump($data);
        $result=$data->fetchAll();
        if (count($result)!=1)
        {
          //echo "Authentication failed";   
            return 0;
        }
        //echo "Authentication success";
	return 1;
    }
    
    public function authenticate()
    {
        $data=$this->conn->query('SELECT Username FROM Test WHERE UserName= '.$this->conn->quote($this->username).'AND Password = '.$this->conn->quote($this->password));
//        echo var_dump($data);
        $result=$data->fetchAll();
        if (count($result)!=1)
        {
          //echo "Authentication failed";   
            return 0;
        }
        //echo "Authentication success";
	return 1;
    }
}