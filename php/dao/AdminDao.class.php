<?php

require_once "../utils/MySQLiUtil.class.php";
require_once "../domain/Admin.class.php";

//Admin表对应的数据库操作的实现类
class AdminDao {
    var $sql_util;
    var $connnet_handle;

    function __construct(){
        $this->sql_util = new MySQLiUtil();
        $this->connnet_handle = $this->sql_util->connect();
    }
    //删除管理员
    function deleteAdmin($admin_id){
        $sql = "DELETE FROM admin WHERE admin_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $admin_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //查找某年度的管理员人数
    function findAdminCountByYear($year){
        $id = "'".$year."%'";
        $sql = "SELECT * FROM admin WHERE (admin_id LIKE $id)";
        $result = $this->connnet_handle->query($sql);
        return $result->num_rows;
    }
    //根据某个ID查找用户
    function findAdminById($user_id){
        $sql = "SELECT * FROM admin WHERE admin_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows;
        
    }
    //更新某个用户的信息
    function updateAdminById($admin){
        $sql = "UPDATE admin SET admin_name = ?, user_level = ?, id_number = ?, sex = ? WHERE admin_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sssis", $admin->admin_name, $admin->user_level, $admin->id_number, $admin->sex, $admin->admin_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //分页查询
    function findByPage($start, $page_size){
        $sql = "SELECT * FROM admin LIMIT ?, ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ii", $start, $page_size);
        $stmt->execute();

        $stmt->store_result();

        $result = array();
        if($stmt->affected_rows > 0) {
            //转化为数组
            for($i = 0; $i < $stmt->affected_rows; $i++) {
                $admin = new Admin();
                $stmt->bind_result($admin->admin_id, $admin->admin_password, $admin->user_level, $admin->admin_name, $admin->id_number, $admin->sex);
                $admin->admin_password = "NULL";
                $stmt->fetch();
                $result[] = get_object_vars($admin);
            }
        }

        return $result;
    }
    //查看有多少管理员
    function countAdmin(){
        $sql = "SELECT * FROM admin";
        $result = $this->connnet_handle->query($sql);   

        return $result->num_rows;
    }
    //添加管理员
    function addAdmin($admin){
        $sql = "INSERT INTO admin VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("sssssi", $admin->admin_id, $admin->admin_password, $admin->user_level, $admin->admin_name, $admin->id_number, $admin->sex);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //修改某个管理员的密码
    function updateAdminPassword($user_id, $new_password){
        $sql = "UPDATE admin SET admin_password = ? WHERE admin_id = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss",$new_password, $user_id);
        $stmt->execute();

        $rows = $stmt->affected_rows;
        $stmt->close();

        return $rows;
    }
    //获取管理员信息
    function getAdminInfo($user_id, $user_password){
        $admin = new Admin();
        
        $sql = "SELECT admin_name, id_number, sex FROM admin WHERE admin_id = ? AND admin_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($admin->admin_name, $admin->id_number, $admin->sex);    

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $admin;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
    //通过ID和密码获取姓名
    function getNameByIdAndPassword($user_id, $user_password){
        $user_name = "";
        
        $sql = "SELECT admin_name FROM admin WHERE admin_id = ? AND admin_password = ?";
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
    //查找管理员等级
    function findAdminByIdAndPassword($user_id, $user_password){
        $user_level = "";
        
        $sql = "SELECT user_level FROM admin WHERE admin_id = ? AND admin_password = ?";
        $stmt = $this->connnet_handle->prepare($sql);
        $stmt->bind_param("ss", $user_id, $user_password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_level);    

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
            return $user_level;
        } 
        else {
            $stmt->close();
            return NULL;
        }
    }
}

?>