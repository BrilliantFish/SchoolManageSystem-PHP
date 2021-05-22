<?php

class MySQLiUtil{
    var $servername;
    var $username;
    var $password;
    var $dbname;
    var $conn;

    function __construct(){
        $this->servername = "127.0.0.1";
        $this->username = "root";
        $this->password = "root";
        $this->dbname = "university_db";
    }
    function __destruct(){
        $this->conn->close();
    }

    function connect(){
        // 创建连接
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

        // 检查连接
        if ($this->conn->connect_error) {
            die("连接失败: " . $this->conn->connect_error);
        } 
        
        return $this->conn;
    }
}

?>