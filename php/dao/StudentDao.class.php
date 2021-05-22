<?php
require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Student.class.php";

//Student表对应的数据库操作的类
class StudentDao {  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //修改教师信息
    function updateStudentInfo($student){
        $sql = "UPDATE student SET student_name = ?, id_number = ?, sex = ?, study_status = ?, birthday = ?,country = ?, address = ?, tellphone = ? WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssiisssss", $student->student_name, $student->id_number, $student->sex, $student->study_status, $student->birthday, $student->country, $student->address, $student->tellphone, $student->student_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
     //获取某个学生信息
     function getStudentInfo($user_id, $user_password){
        $student = new Student();
        
        $sql = "SELECT * FROM student WHERE student_id = ? AND student_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($student->student_id, $student->student_password, $student->id_number, $student->student_name, $student->sex, $student->start_year, $student->study_status, $student->birthday, $student->country, $student->address, $student->tellphone);
        $student->student_password =  "NULL";
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $student;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
    //查询某个课程的学生记录条数
    function countStudentByCourseID($course_id){
        $sql = "SELECT * FROM course_student WHERE course_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $course_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查询某个课程的学生记录条数
    function countStudentByClassID($class_id){
        $sql = "SELECT * FROM class_student WHERE class_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $class_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //学生记录条数
    function countStudent(){
        $sql = "SELECT * FROM student";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //查找某个学生的信息通过学生ID
    function findStudentByStudentID($student_id){
        $student = new Student();
        
        $sql = "SELECT * FROM student WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($student->student_id, $student->student_password, $student->id_number, $student->student_name, $student->sex, $student->start_year, $student->study_status, $student->birthday, $student->country, $student->address, $student->tellphone);
        $student->student_password =  "NULL";
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $student;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
    //查找某门课程下所有学生
    function findByPageAndCourseID($start, $page_size, $course_id){
        $sql = "SELECT student_id FROM course_student WHERE course_id = ? LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sii", $course_id, $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $student_id = "";
                $stmt->bind_result($student_id);
                $stmt->fetch();
                $result[] = $student_id;
            }
        }

        return $result;
    }
    //查找某个班级下所有学生
    function findByPageAndClassID($start, $page_size, $class_id){
        $sql = "SELECT student_id FROM class_student WHERE class_id = ? LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sii", $class_id, $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $student_id = "";
                $stmt->bind_result($student_id);
                $stmt->fetch();
                $result[] = $student_id;
            }
        }

        return $result;
    }
    //删除学生
    function deleteStudent($student_id){
        $sql = "DELETE FROM student WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查找某个学生，某门课的成绩
    function findStudentScore($course_id, $student_id){
        $sql = "SELECT score FROM course_student WHERE course_id = ? AND student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $course_id, $student_id);
        $stmt->execute();

        $stmt->store_result();

        $score = "";
        if($stmt->affected_rows > 0) {
            $stmt->bind_result($score);
            $stmt->fetch();
        }
        $stmt->close();

        return $score;
    }
    //分页查询
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM student LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $student = new Student();
                $stmt->bind_result($student->student_id, $student->student_password, $student->id_number, $student->student_name, $student->sex, $student->start_year, $student->study_status, $student->birthday, $student->country, $student->address, $student->tellphone);
                $student->student_password = "NULL";
                $stmt->fetch();
                $result[] = get_object_vars($student);
            }
        }

        return $result;
    }
    //添加学生
    function addStudent($student){
        $sql = "INSERT INTO student VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssssiiissss", $student->student_id, $student->student_password, $student->id_number, $student->student_name, $student->sex, $student->start_year, $student->study_status, $student->birthday, $student->country, $student->address, $student->tellphone);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //根据学生ID查找学生
    function findStudentById($student_id){
        $sql = "SELECT * FROM student WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
    }
    //获得学生姓名，通过学生ID和密码
    function getNameByIdAndPassword($user_id, $user_password){
        $user_name = "";
        
        $sql = "SELECT student_name FROM student WHERE student_id = ? AND student_password = ?";
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
    //查找学生通过学生ID和密码
    function findStudentByIdAndPassword($user_id, $user_password){
        $sql = "SELECT * FROM student WHERE student_id = ? AND student_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();

        $rows = $stmt->num_rows;

        $stmt->close();

        return $rows;
    }
    //该学生那些课程已经选了
    function findAllChooseCourse($page_number, $page_size, $student_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $result = $this->courseDao->findByPage($start, $page_size);

        $size = sizeof($result);

        $res = array();
        for($i = 0; $i < $size; $i++){
            $course = $result[$i];
            $course_id = $course["course_id"];
            $flag =  $this->courseDao->findCourseByStudentID($course_id, $student_id);
            $res[] = $flag; 
        }

        return $res;
    }
    //修改某个学生的密码
    function updateStudentPassword($user_id, $new_password){
        $sql = "UPDATE student SET student_password = ? WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss",$new_password, $user_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
}
?>