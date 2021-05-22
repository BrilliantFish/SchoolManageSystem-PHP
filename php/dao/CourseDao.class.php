<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Course.class.php";

//Course表对应的数据库操作的实现类
class CourseDao {  
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //查找某个学生是否选了这门课
    function findCourseByStudentID($course_id, $student_id){
        $sql = "SELECT * FROM course_student WHERE course_id = ? AND student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $course_id, $student_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //学生取消选择课程
    function cancelChooseChooseCourse($course_id, $student_id){
        $sql = "DELETE FROM course_student WHERE course_id = ? AND student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $course_id, $student_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //记录成绩
    function recordScore($course_id, $student_id, $score){
        $sql = "UPDATE course_student SET score = ? WHERE course_id = ? AND student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("iss", $score, $course_id, $student_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //删除课程
    function deleteCourse($course_id){
        $sql = "DELETE FROM course WHERE course_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $course_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //学生选课
    function chooseCourse($course_id, $student_id){
        $sql = "INSERT INTO course_student(course_id, student_id) VALUES (?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $course_id, $student_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查找某个教师的课程数目
    function countCourseByTeacherID($teacher_id){
        $sql = "SELECT * FROM course_teacher WHERE teacher_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $teacher_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查找某个学生的课程数目
    function countCourseByStudentID($student_id){
        $sql = "SELECT * FROM course_student WHERE student_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();

        $stmt->store_result();
        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //添加课程
    function addCourse($course){
        $sql = "INSERT INTO course VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ssiiiii", $course->course_id, $course->course_name, $course->course_weekday, $course->start_week, $course->end_week, $course->start_time, $course->end_time);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }  
    //课程的数目
    function countCourse(){
        $sql = "SELECT * FROM course";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //查询某个教师教的课程的分页查询    
    function findByPageAndTeacherID($start, $page_size, $teacher_id){
        $sql = "SELECT course_id FROM course_teacher WHERE teacher_id = ? LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sii", $teacher_id, $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $courseID_arr = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $course_id = "";
                $stmt->bind_result($course_id);
                $stmt->fetch();
                $courseID_arr[] = $course_id;
            }
        }
        $stmt->close();

        $size = count($courseID_arr);

        $result = array();
        for($i = 0; $i < $size; $i++) {
            $course_id = $courseID_arr[$i];
            $sql = "SELECT * FROM course WHERE course_id = ?";
            $stmt = $this->connnet_handle->prepare($sql);
            $stmt->bind_param("s", $course_id);
            $stmt->execute();
            $stmt->store_result();

            $course = new Course();
            $stmt->bind_result($course->course_id, $course->course_name, $course->course_weekday, $course->start_week, $course->end_week, $course->start_time, $course->end_time);
            $stmt->fetch();
            $result[] = get_object_vars($course);
        }


        return $result;
    }
    //查询某个学生所有的课程的成绩的分页查询
    function findStudentScore($start, $page_size, $student_id){
        $sql = "SELECT score FROM course_student WHERE student_id = ? LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sii", $student_id, $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $score_arr = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $score = "";
                $stmt->bind_result($score);
                $stmt->fetch();
                if($score == ""){
                    $score = "NULL";
                }
                $score_arr[] = $score;
            }
        }
        $stmt->close();

        return $score_arr;
    }
    //查询某个学生所有的课程的分页查询    
    function findByPageAndStudentID($start, $page_size, $student_id){
        $sql = "SELECT course_id FROM course_student WHERE student_id = ? LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sii", $student_id, $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $courseID_arr = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $course_id = "";
                $stmt->bind_result($course_id);
                $stmt->fetch();
                $courseID_arr[] = $course_id;
            }
        }
        $stmt->close();

        $size = count($courseID_arr);

        $result = array();
        for($i = 0; $i < $size; $i++) {
            $course_id = $courseID_arr[$i];
            $sql = "SELECT * FROM course WHERE course_id = ?";
            $stmt = $this->connnet_handle->prepare($sql);
            $stmt->bind_param("s", $course_id);
            $stmt->execute();
            $stmt->store_result();

            $course = new Course();
            $stmt->bind_result($course->course_id, $course->course_name, $course->course_weekday, $course->start_week, $course->end_week, $course->start_time, $course->end_time);
            $stmt->fetch();
            $result[] = get_object_vars($course);
        }


        return $result;
    }
    //分页查询    
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM course LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $course = new Course();
                $stmt->bind_result($course->course_id, $course->course_name, $course->course_weekday, $course->start_week, $course->end_week, $course->start_time, $course->end_time);
                $stmt->fetch();
                $result[] = get_object_vars($course);
            }
        }
        $stmt->close();

        return $result;
    }

}

?>