<?php

require_once "../domain/PageBean.class.php";
require_once "../dao/SchoolDao.class.php";

//所有涉及School表的服务的实现
class SchoolService {  
    var $schoolDao;

    function __construct(){
        $this->schoolDao = new SchoolDao();
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->schoolDao->countSchool();   //获取总记录数

        $pagebean->setPageNumber($page_number);           //设置当前页码
        $pagebean->setPageSize($page_size);               //设置每页显示条数
        $pagebean->setTotalCount($total_count);           //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->schoolDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //根据学院ID查找
    function findSchoolById($school_id){
        $rows = $this->schoolDao->findSchoolById($school_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查找某个学院下的专业数有多少
    function findSchoolMajorCount($school_id){
        return $this->schoolDao->findSchoolMajorCount($school_id);
    } 
    //添加学院与专业的联系
    function addSchoolMajor($school, $major){
        $rows = $this->schoolDao->addSchoolMajor($school, $major);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查找所有学院
    function findAllSchool(){
        $pagebean = new PageBean();

        $total_count = $this->schoolDao->countSchool();   //获取总记录数          
        $pagebean->setTotalCount($total_count);           //设置总记录数

        $list = $this->schoolDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //通过学院名称查找学院
    function findSchoolByName($schoolName){
        $rows = $this->schoolDao->findSchoolByName($schoolName);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //添加学院
    function addSchool($school){
        $rows = $this->schoolDao->addSchool($school);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    } 
}

?>