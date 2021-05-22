<?php

require_once "../dao/TeacherDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Teacher表的服务的实现
class TeacherService {  
    var $teacherDao;

    function __construct(){
        $this->teacherDao = new TeacherDao();
    }

    //修改教师信息
    function updateTeacherInfo($teacher){
        $rows = $this->teacherDao->updateTeacherInfo($teacher);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //删除教师
    function deleteTeacher($teacher_id){
        $rows = $this->teacherDao->deleteTeacher($teacher_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //建立教室与课程的联系
    function addTeacherCourse($teacher, $course){
        $rows = $this->teacherDao->addTeacherCourse($teacher, $course);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //找到所有教师
    function findAllTeacher(){
        $pagebean = new PageBean();

        $total_count = $this->teacherDao->countTeacher();     //获取总记录数
        $pagebean->setTotalCount($total_count);               //设置总记录数

        $list = $this->teacherDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->teacherDao->countTeacher();     //获取总记录数

        $pagebean->setPageNumber($page_number);               //设置当前页码
        $pagebean->setPageSize($page_size);                   //设置每页显示条数
        $pagebean->setTotalCount($total_count);               //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;             //开始的记录数
        $list = $this->teacherDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //查询某一年的教师数
    function findTeacherCount($year){
        return $this->teacherDao->findTeacherCount($year);
    }
    //根据教师ID查找教师
    function findTeacherById($teacher_id){
        $rows = $this->teacherDao->findTeacherById($teacher_id);

        if($rows > 0){
            return true;
        }
        else {
            return false;
        }
    }
    //添加教师，参数是Teacher类的实体
    function addTeacher($teacher){
        $rows = $this->teacherDao->addTeacher($teacher);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //登录
    function login($user_id, $user_password){
        $rows = $this->teacherDao->findTeacherByIdAndPassword($user_id, $user_password);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //检查登录
    function checkLogin($user_id, $user_password){
        return $this->teacherDao->getNameByIdAndPassword($user_id, $user_password);
    }
    //获取教师信息
    function getTeacherInfo($user_id, $user_password){
        return $this->teacherDao->getTeacherInfo($user_id, $user_password);
    }
    //更新学生密码
    function updateTeacherPassword($user_id, $new_password){
        if($this->teacherDao->updateTeacherPassword($user_id, $new_password) == 0){
            return false;
        }
        else{
            return true;
        }
    }
}

?>