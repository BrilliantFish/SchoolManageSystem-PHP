<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/CourseService.class.php";

function deleteCourse(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $course_id = $_POST["course_id"];

    if($flag){
        $service = new CourseService();
        $flag = $service->deleteCourse($course_id);
        if($flag){
            $result_info->setAll($flag, "", "成功");
        }
        else{
            $result_info->setAll($flag, "", "不存在该课程");
        } 
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

deleteCourse();

?>