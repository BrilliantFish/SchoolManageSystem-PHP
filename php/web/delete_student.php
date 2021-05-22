<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/StudentService.class.php";

function deleteStudent(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $student_id = $_POST["student_id"];

    if($flag){
        $service = new StudentService();
        $flag = $service->deleteStudent($student_id);
        if($flag){
            $result_info->setAll($flag, "", "成功");
        }
        else{
            $result_info->setAll($flag, "", "不存在该学生");
        } 
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

deleteStudent();

?>