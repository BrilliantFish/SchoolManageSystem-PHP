<?php

require_once "../dao/AdminDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Admin表的服务的实现
class AdminService{  
    var $adminDao;

    function __construct(){
        $this->adminDao = new AdminDao();
    }
    //删除管理员
    function deleteAdmin($admin_id){
        $rows = $this->adminDao->deleteAdmin($admin_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查找某年度的管理员人数
    function findAdminCount($year){
        return $this->adminDao->findAdminCountByYear($year);
    }
    //根据管理员ID查找
    function findAdminById($user_id){
        $result = $this->adminDao->findAdminById($user_id);

        if($result > 0){   //找到
            return true;
        }
        else{
            return false;
        }
    }
    //更新管理员信息
    function updateAdminInfo($admin){
        $flag = true;

        if(isset($admin->admin_id) && isset($admin->admin_name) && isset($admin->sex) && isset($admin->user_level) && isset($admin->id_number)){
            $rows = $this->adminDao->updateAdminById($admin);
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
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->adminDao->countAdmin();   //获取总记录数

        $pagebean->setPageNumber($page_number);         //设置当前页码
        $pagebean->setPageSize($page_size);             //设置每页显示条数
        $pagebean->setTotalCount($total_count);         //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->adminDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //添加管理员
    function addAdmin($admin){
        $flag = true;

        if(isset($admin->admin_id) && isset($admin->admin_name) && isset($admin->admin_password) && isset($admin->sex) && isset($admin->user_level) && isset($admin->id_number)){
            $rows = $this->adminDao->addAdmin($admin);
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
    //登录
    function login($user_id, $user_password){  
        return $this->adminDao->findAdminByIdAndPassword($user_id, $user_password);
    }
    //检查登录
    function checkLogin($user_id, $user_password){
        return $this->adminDao->getNameByIdAndPassword($user_id, $user_password);
    }
    //获取管理员信息
    function getAdminInfo($user_id, $user_password){
        return $this->adminDao->getAdminInfo($user_id, $user_password);
    }
    //更新管理员密码
    function updateAdminPassword($user_id, $new_password){
        if($this->adminDao->updateAdminPassword($user_id, $new_password) == 0){
            return false;
        }
        else{
            return true;
        }
    }

}

?>