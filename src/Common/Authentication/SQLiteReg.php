<?php

namespace Common\Authentication;
use PDO;

class SQLiteReg
{
    public function __construct($username, $password)
    {
        $this->username=$username;
        $this->password=$password;
        
        try
        {
            $this->conn = new PDO('sqlite:../data/SQLitetest.sqlite');
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo 'ERROR: ' . $e->getMessage();
        }
        
    }
    public function getProfile()
    {
        $data->$this->conn->query('SELECT firstname, lastname, phone FROM Test WHERE UserID = '.$this->conn->quote($this->username));
        return $data->fetchAll();
        
    }
    
    
    public function registerNewUser()
    {
        $data=$this->conn->query('SELECT Username FROM Test WHERE UserName= '.$this->conn->quote($this->username));
        
        $result=$data->fetchAll();
        
        if(count($result)!==0)
        {
            //false
            return 0;
        }
        $this->conn->query('INSERT INTO Test (Username, Password) VALUES ('
                .$this->conn->quote($this->username).','
                    .$this->conn->quote($this->password).')');
        
        $data=$this->conn->query('SELECT Username FROM Test WHERE UserName= '.$this->conn->quote($this->username));
//        echo var_dump($data);
        $result=$data->fetchAll();
        
        if (count($result)!==1)
        {
            //false
            return 0;
        }
        //true
        return 1;
        
    }

}