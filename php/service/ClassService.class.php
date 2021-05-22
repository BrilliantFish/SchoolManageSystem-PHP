<?php

require_once "../dao/ClassDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Class表的服务的实现
class ClassService {  
    var $classDao;

    function __construct(){
        $this->classDao = new ClassDao();
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->classDao->countClass();     //获取总记录数

        $pagebean->setPageNumber($page_number);           //设置当前页码
        $pagebean->setPageSize($page_size);               //设置每页显示条数
        $pagebean->setTotalCount($total_count);           //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->classDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //建立班级与某个学生的联系
    function addClassStudent($class, $student){
        $rows = $this->classDao->addClassStudent($class, $student);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查询某个班级有几个学生
    function findClassStudentCount($class_id){
        return $this->classDao->findClassStudentCount($class_id);
    }
    //根据专业ID查找旗下的班级
    function findClassByMajorID($major_id){
        $pagebean = new PageBean();

        $list = $this->classDao->findClassByMajorID($major_id);
        $pagebean->setList($list);
        $pagebean->setTotalCount(count($list));                 //设置总记录数
        
        return $pagebean;
    }
    //添加班级
    function addClass($class){
        $flag = true;

        if(isset($class->class_id) && isset($class->class_name) && isset($class->class_year) && isset($class->class_number)){
            $rows = $this->classDao->addClass($class);
            if($rows > 0){ 
                $flag = true;
            }
            else{
                $flag = false;
            }
        }
        else{
            $flag = false;
        }

        return $flag;
    }
    //依据班级号码查找班级
    function findClassById($class_id){
        $rows = $this->classDao->findClassById($class_id);

        if($rows > 0){
            return true;
        }
        else {
            return false;
        }
    }
    //查找所有班级
    function findAllClass(){
        $pagebean = new PageBean();

        $total_count = $this->classDao->countClass();   //获取总记录数          
        $pagebean->setTotalCount($total_count);         //设置总记录数

        $list = $this->classDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }

}

?>