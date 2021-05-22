<?php

require_once "check_login_info.php";
require_once "../domain/School.class.php";
require_once "../domain/Major.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";
require_once "../service/MajorService.class.php";


//获取前端发送来的学院的表单数据
function getSchoolInfo(){
    $school = new School();
    $school->school_id = $_POST["school_id"];
    $school->school_name = $_POST["school_name"];

    return $school;
}

//添加学院与专业的联系
function addSchoolMajor($major){
    $school = getSchoolInfo();
    $schoolService = new SchoolService();
    return $schoolService->addSchoolMajor($school, $major);
}

//获取前端发送来的专业的表单数据
function getMajorInfo(){
    $major = new Major();
    $major->major_id = $_POST["major_id"];
    $major->major_name = $_POST["major_name"];

    return $major;
}

function addMajor(){
    $result_info = new ResultInfo();
    $major = getMajorInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new MajorService();
        $flag = $service->addMajor($major);
        if($flag){  
            $flag = addSchoolMajor($major);
            if($flag){
                $result_info->setAll($flag, $major, "添加专业成功");
            }
            else{
                $result_info->setAll($flag, $major, "添加专业成功，但是与学院建立联系失败！");
            }
        }
        else{
            $result_info->setAll($flag, $major, "注册失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

addMajor();


?>