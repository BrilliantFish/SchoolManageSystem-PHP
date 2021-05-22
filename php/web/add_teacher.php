<?php

require_once "check_login_info.php";
require_once "../domain/Teacher.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/TeacherService.class.php";

function getTeacherInfo(){         //获取前端发送来的表单数据
    $teacher = new Teacher();
    $teacher->teacher_id = $_POST["teacher_id"];
    $teacher->teacher_password = $_POST["teacher_password"];
    $teacher->id_number = $_POST["id_number"];
    $teacher->teacher_name = $_POST["teacher_name"];
    $teacher->sex = $_POST["sex"];
    $teacher->work_status = $_POST["work_status"];
    $teacher->birthday = $_POST["birthday"];
    $teacher->country = $_POST["country"];
    $teacher->address = $_POST["address"];
    $teacher->tellphone = $_POST["tellphone"];

    return $teacher;
}

function addTeacher(){
    $result_info = new ResultInfo();
    $teacher = getTeacherInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new TeacherService();
        $flag = $service->addTeacher($teacher);
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

addTeacher();


?>