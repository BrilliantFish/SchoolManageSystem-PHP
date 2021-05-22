<?php

require_once "../dao/ClassroomDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Classroom表的服务的实现
class ClassroomService{  
    var $classroomDao;

    function __construct(){
        $this->classroomDao = new ClassroomDao();
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->classroomDao->countClassroom();     //获取总记录数

        $pagebean->setPageNumber($page_number);           //设置当前页码
        $pagebean->setPageSize($page_size);               //设置每页显示条数
        $pagebean->setTotalCount($total_count);           //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->classroomDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //建立教室与课程的联系
    function addClassroomCourse($classroom,$course){
        $rows =  $this->classroomDao->addClassroomCourse($classroom, $course);

        if($rows){
            return true;
        }
        else{
            return false;
        }
    }
    //查找所有教室
    function findAllClassroom(){
        $pagebean = new PageBean();

        $total_count = $this->classroomDao->countClassroom();   //获取总记录数          
        $pagebean->setTotalCount($total_count);                 //设置总记录数

        $list = $this->classroomDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //添加教室
    function addClassroom($classroom){
        $rows = $this->classroomDao->addClassroom($classroom);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //删除教室
    function deleteClassroom($classroom_id){
        $rows = $this->classroomDao->deleteClassroom($classroom_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //根据教室名称查找教室
    function findClassroomByName($classroom_name){
        $rows = $this->classroomDao->findClassroomByName($classroom_name);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
}

?>