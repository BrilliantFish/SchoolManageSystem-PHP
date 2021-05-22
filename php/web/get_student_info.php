<?php

require "../domain/ResultInfo.class.php";
require "../service/StudentService.class.php";
require "check_login_info.php";

function getStudentInfo(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new StudentService();
        $data = $service->getStudentInfo($_SESSION["user_id"], $_SESSION["user_password"]);
        $result_info->setAll($flag, $data, "已经登陆");
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

getStudentInfo();


?>