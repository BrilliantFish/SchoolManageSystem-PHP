<?php

require_once "check_login_info.php";
require_once "../domain/Admin.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/AdminService.class.php";

function getAdminInfo(){   //获取前端发送来的表单数据
    $admin = new Admin();
    $admin->admin_id = $_POST["admin_id"];
    $admin->admin_name = $_POST["admin_name"];
    $admin->sex = $_POST["sex"];
    $admin->user_level = $_POST["user_level"];
    $admin->id_number = $_POST["id_number"];

    return $admin;
}

function updateAdminInfo(){
    $result_info = new ResultInfo();
    $admin = getAdminInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new AdminService();
        $flag = $service->updateAdminInfo($admin);
        if($flag){  
            $result_info->setAll($flag, $flag, "修改信息成功");
        }
        else{
            $result_info->setAll($flag, $flag, "修改信息失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

updateAdminInfo();


?>