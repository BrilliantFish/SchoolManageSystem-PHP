<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Classes.class.php";

//Class表对应的数据库操作的实现类
class ClassDao{  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }

    //建立班级与某个学生的联系
    function addClassStudent($class, $student){
        $student_number = substr($student->student_id, 10, 2);
        $sql = "INSERT INTO class_student (class_id, student_id, student_number) VALUES (?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssi", $class->class_id, $student->student_id, $student_number);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查询某个班级有几个学生
    function findClassStudentCount($class_id){
        $sql = "SELECT * FROM class_student WHERE class_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $class_id);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;    //记录学生数目
        $stmt->close();

        return $rows;
    }
    //根据专业ID查找旗下所有的班级
    function findClassByMajorID($major_id){
        $sql = "SELECT class_id FROM major_class WHERE major_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $major_id);
        $stmt->execute();
        $stmt->store_result();

        $classArr = array();
        if ($stmt->num_rows > 0) {
            for($i = 0; $i < $stmt->num_rows; $i++){
                $class_id = "";
                $stmt->bind_result($class_id); 
                $stmt->fetch();
                $classArr[] = $class_id;
            }
        } 
        $stmt->close();

        
        $result = array();
        for($j = 0; $j < count($classArr); $j++){
            $sql = "SELECT * FROM class WHERE class_id = ?";
            $stmt = $this->connnet_handle->prepare($sql);
            $stmt->bind_param("s", $classArr[$j]);
            $stmt->execute();

            $stmt->store_result();

            if($stmt->affected_rows > 0) {
                //转化为数组
                for($i = 0; $i < $stmt->affected_rows; $i++) {
                    $class = new Classes();
                    $stmt->bind_result($class->class_id, $class->class_name, $class->class_year, $class->class_number);
                    $stmt->fetch();
                    $result[] = get_object_vars($class);
                }
            }
        }

        return $result;

    }
    //添加班级
    function addClass($class){
        $sql = "INSERT INTO class (class_id, class_name, class_year, class_number) VALUES (?, ?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssii", $class->class_id, $class->class_name, $class->class_year, $class->class_number);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //依据班级号码查找班级
    function findClassById($class_id){
        $sql = "SELECT * FROM class WHERE class_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $class_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
    //班级的记录数
    function countClass(){
        $sql = "SELECT * FROM class";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //分页查找
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM class LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $class = new Classes();
                $stmt->bind_result($class->class_id, $class->class_name, $class->class_year, $class->class_number);
                $stmt->fetch();
                $result[] = get_object_vars($class);
            }
        }

        return $result;
    }
}

?>