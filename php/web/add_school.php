<?php

require_once "check_login_info.php";
require_once "../domain/School.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";

function getSchoolInfo(){   //获取前端发送来的表单数据
    $school = new School();
    $school->school_id = $_POST["school_id"];
    $school->school_name = $_POST["school_name"];

    return $school;
}

function addSchool(){
    $result_info = new ResultInfo();
    $school = getSchoolInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new SchoolService();
        $flag = $service->addSchool($school);
        if($flag){  
            $result_info->setAll($flag, $flag, "注册成功");
        }
        else{
            $result_info->setAll($flag, $flag, "注册失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

addSchool();


?>