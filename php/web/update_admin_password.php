<?php

require "../domain/ResultInfo.class.php";
require "../service/AdminService.class.php";
require "check_login_info.php";

//修改cookie和session的值，不然还是之前的值，虽然相等，但是找不到用户
function updateLoginInfo($new_password){ 
    session_start();
    $time = time()+3600;
    $_SESSION["user_password"] = $new_password;
    setcookie("user_password", $new_password, $time, "/");
}

function updateAdminPassword(){
    $result_info = new ResultInfo();
    $new_password = $_POST["first_password"];
    $flag = checkLoginInfo();

    if($flag){
        if(!isset($new_password)){
            $flag = false;
            $result_info->setAll($flag, $flag, "无新的密码");
        }
        else{
            $service = new AdminService();
            $flag = $service->updateAdminPassword($_SESSION["user_id"], $new_password);
            if($flag){
                $result_info->setAll($flag, $flag, "已经登陆");
                updateLoginInfo($new_password);
            }
            else{
                $result_info->setAll($flag, $flag, "更新密码失败");
            }
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

updateAdminPassword();

?>