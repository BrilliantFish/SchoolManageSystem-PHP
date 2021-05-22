<?php

require "../domain/ResultInfo.class.php";
require "../service/TeacherService.class.php";

//登录成功，保存登录信息
function setLoginInfo($user_id, $user_password){        
    session_start();
    $time = time()+3600;
    $_SESSION["user_id"] = $user_id;
    $_SESSION["user_password"] = $user_password;
    setcookie("user_id", $user_id, $time, "/");
    setcookie("user_password", $user_password, $time, "/");
}

function teacherLogin(){
    $user_id = $_POST["user_id"];
    $user_password = $_POST["user_password"];

    $result_info = new ResultInfo();   //结果集
    $service = new TeacherService();
    $flag = $service->login($user_id, $user_password);

    if($flag){
        $result_info->setAll($flag, NULL, "存在该用户");
        setLoginInfo($user_id, $user_password);
    }
    else{
        $result_info->setAll($flag, NULL, "查无此人！");
    }

    //JSON_UNESCAPED_UNICODE这个参数让中文数据还是中文
    echo json_encode($result_info, JSON_UNESCAPED_UNICODE); 
}

teacherLogin();

?>