<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/CourseService.class.php";

function recordScore(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $course_id = $_POST["course_id"];
    $student_id = $_POST["student_id"];
    $score =$_POST["score"];

    if($flag){
        $service = new CourseService();
        $flag = $service->recordScore($course_id, $student_id, $score);
        if($flag){
            $result_info->setAll($flag, NULL, "成绩记录成功");
        }
        else{
            $result_info->setAll(false, NULL, "成绩记录失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

recordScore();

?>