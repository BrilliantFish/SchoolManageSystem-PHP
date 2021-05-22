<?php

require "../domain/ResultInfo.class.php";
require "../service/AdminService.class.php";

 //登录成功，保存登录信息
function setLoginInfo($user_id, $user_password, $user_level){       
    session_start();
    $time = time()+3600;
    $_SESSION["user_id"] = $user_id;
    $_SESSION["user_password"] = $user_password;
    $_SESSION["user_level"] = $user_level;
    setcookie("user_id", $user_id, $time, "/");
    setcookie("user_password", $user_password, $time, "/");
    setcookie("user_level", $user_level, $time, "/");
}

function adminLogin(){
    $user_id = $_POST["user_id"];
    $user_password = $_POST["user_password"];

    $result_info = new ResultInfo();   //结果集
    $service = new AdminService();
    $data = $service->login($user_id, $user_password);

    if($data == NULL){
        $result_info->setAll(false, NULL, "查无此人！");
    }
    else{
        $result_info->setAll(true, $data, "存在该用户");
        setLoginInfo($user_id, $user_password, $data);
    }

    //JSON_UNESCAPED_UNICODE这个参数让中文数据还是中文
    echo json_encode($result_info, JSON_UNESCAPED_UNICODE); 
}

adminLogin();

?>