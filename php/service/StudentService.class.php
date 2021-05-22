<?php

require_once "../dao/StudentDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Student表的服务的实现
class StudentService {  
    var $studentDao;

    function __construct(){
        $this->studentDao = new StudentDao();
    }

    //修改教师信息
    function updateStudentInfo($student){
        $rows = $this->studentDao->updateStudentInfo($student);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
     //分页查询
     function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->studentDao->countStudent();     //获取总记录数

        $pagebean->setPageNumber($page_number);               //设置当前页码
        $pagebean->setPageSize($page_size);                   //设置每页显示条数
        $pagebean->setTotalCount($total_count);               //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;             //开始的记录数
        $list = $this->studentDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //添加学生
    function addStudent($student){
        $rows = $this->studentDao->addStudent($student);

        if($rows > 0){
            return true;
        }
        else {
            return false;
        }
    }
    //根据学生ID查找学生
    function findStudentById($student_id){
        $rows = $this->studentDao->findStudentById($student_id);

        if($rows > 0){
            return true;
        }
        else {
            return false;
        }

    }
    //登录
    function login($user_id, $user_password){
        $rows = $this->studentDao->findStudentByIdAndPassword($user_id, $user_password);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //检查登录
    function checkLogin($user_id, $user_password){
        return $this->studentDao->getNameByIdAndPassword($user_id, $user_password);
    }
    //更新学生密码
    function updateStudentPassword($user_id, $new_password){
        if($this->studentDao->updateStudentPassword($user_id, $new_password) == 0){
            return false;
        }
        else{
            return true;
        }
    }
    //查找某个课程下的所有学生
    function pageQueryByCourseID($page_number, $page_size, $course_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $result = $this->studentDao->findByPageAndCourseID($start, $page_size, $course_id);

        $size = sizeof($result);

        $res = array();
        for($i = 0; $i < $size; $i++){
            $student_id = $result[$i];
            $s =  $this->studentDao->findStudentByStudentID($student_id);
            $res[] = get_object_vars($s);
        }

        $pagebean = new PageBean();

        $total_count = $this->studentDao->countStudentByCourseID($course_id);     //获取总记录数

        $pagebean->setPageNumber($page_number);               //设置当前页码
        $pagebean->setPageSize($page_size);                   //设置每页显示条数
        $pagebean->setTotalCount($total_count);               //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);
        $pagebean->setList($res);
        
        return $pagebean;
    }
    //查找某个课程下的所有学生
    function pageQueryByClassID($page_number, $page_size, $class_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $result = $this->studentDao->findByPageAndClassID($start, $page_size, $class_id);

        $size = sizeof($result);

        $res = array();
        for($i = 0; $i < $size; $i++){
            $student_id = $result[$i];
            $s =  $this->studentDao->findStudentByStudentID($student_id);
            $res[] = get_object_vars($s);
        }

        $pagebean = new PageBean();

        $total_count = $this->studentDao->countStudentByClassID($class_id);     //获取总记录数

        $pagebean->setPageNumber($page_number);               //设置当前页码
        $pagebean->setPageSize($page_size);                   //设置每页显示条数
        $pagebean->setTotalCount($total_count);               //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);
        $pagebean->setList($res);
        
        return $pagebean;
    }
    //查找某个课程下的所有学生的成绩
    function pageQueryScoreByCourseID($page_number, $page_size, $course_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $result = $this->studentDao->findByPageAndCourseID($start, $page_size, $course_id);

        $size = sizeof($result);

        $res = array();
        for($i = 0; $i < $size; $i++){
            $student_id = $result[$i];
            $s =  $this->studentDao->findStudentScore($course_id, $student_id);
            $res[] = $s;
        }
        
        return $res;
    }
    //删除学生
    function deleteStudent($student_id){
        $rows = $this->studentDao->deleteStudent($student_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //获取某个学生信息
    function getStudentInfo($user_id, $user_password){
        return $this->studentDao->getStudentInfo($user_id, $user_password);
    }

}
?>