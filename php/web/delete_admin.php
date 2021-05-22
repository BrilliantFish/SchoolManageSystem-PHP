<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/AdminService.class.php";

function deleteAdmin(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $admin_id = $_POST["admin_id"];

    if($flag){
        $service = new AdminService();
        $flag = $service->deleteAdmin($admin_id);
        if($flag){
            $result_info->setAll($flag, "", "成功");
        }
        else{
            $result_info->setAll($flag, "", "不存在该管理员");
        } 
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

deleteAdmin();

?>