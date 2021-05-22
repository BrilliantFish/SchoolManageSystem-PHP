<?php
require_once "../dao/MajorDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Major表的服务的实现
class MajorService {  
    var $majorDao;

    function __construct(){
        $this->majorDao = new MajorDao();
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->majorDao->countMajor();     //获取总记录数

        $pagebean->setPageNumber($page_number);           //设置当前页码
        $pagebean->setPageSize($page_size);               //设置每页显示条数
        $pagebean->setTotalCount($total_count);           //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->majorDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //查找某个专业下的班级数
    function findMajorClassCount($major_id, $year){
        return $this->majorDao->findMajorClassCount($major_id, $year);
    }
    //建立专业与班级的联系
    function addMajorClass($major, $class){
        $rows = $this->majorDao->addSchoolMajor($major, $class);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //根据学院ID查找旗下的所有专业
    function findMajorBySchoolID($school_id){
        $pagebean = new PageBean();

        $list = $this->majorDao->findMajorBySchoolID($school_id);
        $pagebean->setList($list);
        $pagebean->setTotalCount(count($list));         //设置总记录数
        
        return $pagebean;
        
    }
    //查找所有专业
    function findAllMajor(){
        $pagebean = new PageBean();

        $total_count = $this->majorDao->countMajor();   //获取总记录数          
        $pagebean->setTotalCount($total_count);         //设置总记录数

        $list = $this->majorDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //添加专业，参数是Major类的实体
    function addMajor($major){
        $rows = $this->majorDao->addMajor($major);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //根据专业ID查找专业
    function findMajorById($major_id){
        $rows = $this->majorDao->findMajorById($major_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //根据专业名称查找专业
    function findMajorByName($major_Name){
        $rows = $this->majorDao->findMajorByName($major_Name);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
?>