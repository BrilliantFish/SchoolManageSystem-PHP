<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Classroom.class.php";

//Classroom表对应的数据库操作的实现类
class ClassroomDao {  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //删除教室
    function deleteClassroom($classroom_id){
        $sql = "DELETE FROM classroom WHERE classroom_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("i", $classroom_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //建立教室与课程的联系
    function addClassroomCourse($classroom,$course){
        $sql = "INSERT INTO classroom_course (classroom_id, course_id) VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("is", $classroom->classroom_id, $course->course_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //教室数量
    function countClassroom(){
        $sql = "SELECT * FROM classroom";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //分页查询    
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM classroom LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $classroom = new Classroom();
                $stmt->bind_result($classroom->classroom_id, $classroom->classroom_name);
                $stmt->fetch();
                $result[] = get_object_vars($classroom);
            }
        }

        return $result;
    }
    //添加教室
    function addClassroom($classroom){
        $sql = "INSERT INTO classroom (classroom_name) VALUES (?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $classroom->classroom_name);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //依据教室名称查找教室
    function findClassroomByName($classroom_name){
        $sql = "SELECT * FROM classroom WHERE classroom_name = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $classroom_name);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
}

?>