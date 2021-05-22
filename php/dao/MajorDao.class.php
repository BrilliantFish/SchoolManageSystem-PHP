<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Major.class.php";

//Major表对应的数据库操作类
class MajorDao{  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //查找某个专业下的班级数
    function findMajorClassCount($major_id, $year){
        $y = "'".$year."%'";
        $sql = "SELECT * FROM major_class WHERE major_id = ? and class_id LIKE $y";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $major_id);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;      //记录班级数目
        $stmt->close();

        return $rows;
    }
    //建立专业与班级的联系
    function addSchoolMajor($major, $class){
        $sql = "INSERT INTO major_class (major_id, class_id) VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $major->major_id, $class->class_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //根据学院ID查找旗下所有的专业
    function findMajorBySchoolID($school_id){
        $sql = "SELECT major_id FROM school_major WHERE school_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("i", $school_id);
        $stmt->execute();
        $stmt->store_result();

        $majorArr = array();
        if ($stmt->num_rows > 0) {
            for($i = 0; $i < $stmt->num_rows; $i++){
                $major_id = "";
                $stmt->bind_result($major_id); 
                $stmt->fetch();
                $majorArr[] = $major_id;
            }
        } 
        $stmt->close();

        
        $result = array();
        for($j = 0; $j < count($majorArr); $j++){
            $sql = "SELECT * FROM major WHERE major_id = ?";
            $stmt = $this->connnet_handle->prepare($sql);
            $stmt->bind_param("s", $majorArr[$j]);
            $stmt->execute();

            $stmt->store_result();

            if($stmt->affected_rows > 0) {
                //转化为数组
                for($i = 0; $i < $stmt->affected_rows; $i++) {
                    $major = new Major();
                    $stmt->bind_result($major->major_id, $major->major_name);
                    $stmt->fetch();
                    $result[] = get_object_vars($major);
                }
            }
        }

        return $result;

    }
    //分页查询
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM major LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $major = new Major();
                $stmt->bind_result($major->major_id, $major->major_name);
                $stmt->fetch();
                $result[] = get_object_vars($major);
            }
        }

        return $result;
    }
    //专业记录条数
    function countMajor(){
        $sql = "SELECT * FROM major";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //添加专业
    function addMajor($major){
        $sql = "INSERT INTO major VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $major->major_id, $major->major_name);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //根据专业ID查找专业
    function findMajorById($major_id){
        $sql = "SELECT * FROM major WHERE major_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $major_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
    //根据专业名称查找专业
    function findMajorByName($major_name){
        $sql = "SELECT * FROM major WHERE major_name = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $major_name);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
}

?>