<?php

require "../domain/ResultInfo.class.php";
require "../service/AdminService.class.php";
require "../service/TeacherService.class.php";
require "../service/StudentService.class.php";
require "check_login_info.php";

function checkLogin(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();

    if($flag){
        $user_type = $_POST["user_type"];
        $service = NULL;
        $data = NULL;
        if($user_type == "admin"){
            $service = new AdminService();
            $data = $service->checkLogin($_SESSION["user_id"], $_SESSION["user_password"]);
        }
        else if($user_type == "teacher"){
            $service = new TeacherService();
            $data = $service->checkLogin($_SESSION["user_id"], $_SESSION["user_password"]);
        }
        else if($user_type == "student"){
            $service = new StudentService();
            $data = $service->checkLogin($_SESSION["user_id"], $_SESSION["user_password"]);
        }
        $result_info->setAll($flag, $data, "已经登陆");
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

checkLogin();


?>