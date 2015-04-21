<?php

namespace Common\Authentication;
use PDO;

class SQLiteReg
{
    public function __construct($username, $password)
    {
        $this->username=$username;
        
        if($password!==NULL)
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
        $data=$this->conn->query('SELECT username, first, last, email, twitter, data FROM Test WHERE username ='.$this->conn->quote($this->username));
        foreach ($data->fetchAll() as $i)
        {
            //echo "test1";
            //$S = "<div><p>username: $i[0]<br />firstname: $i[1]<br />lastname: $i[2]<br />email: $i[3]<br />twitter: $i[4]<br />data: $i[5]<br /></p></div>";
            $S = array($i[0], $i[1], $i[2], $i[3], $i[4], $i[5]);
            //var_dump($S);
            //echo $S;
            return $S;
            //echo var_dump($i);
            //echo "test2";
        }
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