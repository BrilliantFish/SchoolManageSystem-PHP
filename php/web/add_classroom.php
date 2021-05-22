<?php

require_once "check_login_info.php";
require_once "../domain/Classroom.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassroomService.class.php";

//获取前端发送来的教室的表单数据
function getClassroomInfo(){   
    $classroom = new Classroom();
    $classroom->classroom_name = $_POST["classroom_name"];

    return $classroom;
}

function addClassroom(){
    $result_info = new ResultInfo();
    $classroom = getClassroomInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new ClassroomService();
        $flag = $service->addClassroom($classroom);
        if($flag){
            $result_info->setAll($flag, NULL, "注册成功");
        }
        else{
            $result_info->setAll($flag, NULL, "注册失败");
        }
        
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

addClassroom();


?>