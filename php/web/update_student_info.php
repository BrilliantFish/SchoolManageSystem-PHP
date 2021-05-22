<?php

require_once "check_login_info.php";
require_once "../domain/Student.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/StudentService.class.php";

function getStudentInfo(){   //获取前端发送来的表单数据
    $student = new Student();
    $student->student_id = $_POST["student_id"];
    $student->student_password = $_POST["student_password"];
    $student->id_number = $_POST["id_number"];
    $student->student_name = $_POST["student_name"];
    $student->start_year = $_POST["start_year"];
    $student->sex = $_POST["sex"];
    $student->study_status = $_POST["study_status"];
    $student->birthday = $_POST["birthday"];
    $student->country = $_POST["country"];
    $student->address = $_POST["address"];
    $student->tellphone = $_POST["tellphone"];


    return $student;
}

function updateStudentInfo(){
    $result_info = new ResultInfo();
    $student = getStudentInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new StudentService();
        $flag = $service->updateStudentInfo($student);
        if($flag){  
            $result_info->setAll($flag, $flag, "修改信息成功");
        }
        else{
            $result_info->setAll($flag, $flag, "修改信息失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

updateStudentInfo();


?>