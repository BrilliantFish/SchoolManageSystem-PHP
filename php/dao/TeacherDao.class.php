<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Teacher.class.php";

//Teacher表对应的数据库操作的实现类
class TeacherDao{  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //删除教师
    function deleteTeacher($teacher_id){
        $sql = "DELETE FROM teacher WHERE teacher_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $teacher_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //修改教师信息
    function updateTeacherInfo($teacher){
        $sql = "UPDATE teacher SET teacher_name = ?, id_number = ?, sex = ?, work_status = ?, birthday = ?,country = ?, address = ?, tellphone = ? WHERE teacher_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssiisssss", $teacher->teacher_name, $teacher->id_number, $teacher->sex, $teacher->work_status, $teacher->birthday, $teacher->country, $teacher->address, $teacher->tellphone, $teacher->teacher_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //建立教室与课程的联系
    function addTeacherCourse($teacher, $course){
        $sql = "INSERT INTO course_teacher (teacher_id, course_id) VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $teacher->teacher_id, $course->course_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //教师记录条数
    function countTeacher(){
        $sql = "SELECT * FROM teacher";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //分页查询
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM teacher LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $teacher = new Teacher();
                $stmt->bind_result($teacher->teacher_id, $teacher->teacher_password, $teacher->id_number, $teacher->teacher_name, $teacher->sex, $teacher->work_status, $teacher->birthday, $teacher->country, $teacher->address, $teacher->tellphone);
                $teacher->teacher_password = "NULL";
                $stmt->fetch();
                $result[] = get_object_vars($teacher);
            }
        }

        return $result;
    }
    //查询某一年的教师数量
    function findTeacherCount($year){
        $id = "'".$year."%'";
        $sql = "SELECT * FROM teacher WHERE (teacher_id LIKE $id)";
        $result = $this->connnet_handle->query($sql);
        return $result->num_rows;
    }
    //根据教师ID查找教师
    function findTeacherById($teacher_id){
        $sql = "SELECT * FROM teacher WHERE teacher_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $teacher_id);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->close();

        return $rows;
    }
    //添加教师
    function addTeacher($teacher){
        $sql = "INSERT INTO teacher VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssssiissss", $teacher->teacher_id, $teacher->teacher_password, $teacher->id_number, $teacher->teacher_name, $teacher->sex, $teacher->work_status, $teacher->birthday, $teacher->country, $teacher->address, $teacher->tellphone);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //通过教师ID和密码获取教师姓名
    function getNameByIdAndPassword($user_id, $user_password){
        $user_name = "";
        
        $sql = "SELECT teacher_name FROM teacher WHERE teacher_id = ? AND teacher_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_name);    

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $user_name;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
    //查找教师通过教师ID和密码
    function findTeacherByIdAndPassword($user_id, $user_password){
        $sql = "SELECT * FROM teacher WHERE teacher_id = ? AND teacher_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();

        $rows = $stmt->num_rows;

        $stmt->close();

        return $rows;
    }
    //获取教师信息
    function getTeacherInfo($user_id, $user_password){
        $teacher = new Teacher();
        
        $sql = "SELECT * FROM teacher WHERE teacher_id = ? AND teacher_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($teacher->teacher_id, $teacher->teacher_password, $teacher->id_number, $teacher->teacher_name, $teacher->sex, $teacher->work_status, $teacher->birthday, $teacher->country, $teacher->address, $teacher->tellphone);    
        $teacher->teacher_password =  "NULL";
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $teacher;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
    //修改某个教师的密码
    function updateTeacherPassword($user_id, $new_password){
        $sql = "UPDATE teacher SET teacher_password = ? WHERE teacher_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss",$new_password, $user_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
}

?>