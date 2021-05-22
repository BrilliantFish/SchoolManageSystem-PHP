<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/School.class.php";

//School表对应的数据库操作类
class SchoolDao {  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //根据学院ID查找
    function findSchoolById($school_id){
        $sql = "SELECT * FROM school WHERE school_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $school_id);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->close();

        return $rows;
    }
    //查找某个学院下的专业数有多少
    function findSchoolMajorCount($school_id){
        $sql = "SELECT * FROM school_major WHERE school_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $school_id);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;    //记录专业数目
        $stmt->close();

        return $rows;
    }
    //建立学院与专业的联系
    function addSchoolMajor($school, $major){
        $sql = "INSERT INTO school_major (school_id, major_id) VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("is", $school->school_id, $major->major_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //分页查询    
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM school LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $school = new School();
                $stmt->bind_result($school->school_id, $school->school_name);
                $stmt->fetch();
                $result[] = get_object_vars($school);
            }
        }

        return $result;
    }
    //学院记录条数
    function countSchool(){
        $sql = "SELECT * FROM school";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //添加学院
    function addSchool($school){
        $sql = "INSERT INTO school VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $school->school_id, $school->school_name);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //根据学院名称查询学院
    function findSchoolByName($schoolName){
        $sql = "SELECT * FROM school WHERE school_name = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $schoolName);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
}

?>