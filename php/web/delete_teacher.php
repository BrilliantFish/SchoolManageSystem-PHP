<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/TeacherService.class.php";

function deleteTeacher(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $teacher_id = $_POST["teacher_id"];

    if($flag){
        $service = new TeacherService();
        $flag = $service->deleteTeacher($teacher_id);
        if($flag){
            $result_info->setAll($flag, "", "成功");
        }
        else{
            $result_info->setAll($flag, "", "不存在该教师");
        } 
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

deleteTeacher();

?>