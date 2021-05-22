<?php

require_once "check_login_info.php";
require_once "../domain/Classroom.class.php";
require_once "../domain/Course.class.php";
require_once "../domain/Teacher.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassroomService.class.php";
require_once "../service/CourseService.class.php";
require_once "../service/TeacherService.class.php";

//获取当前登录学生的ID
function getStudentID(){   
    session_start();

    return $_SESSION["user_id"];
}

//获取前端发送来的课程ID
function getCourseID(){   
    return $_POST["course_id"];
}

//学生取消选择课程
function cancelChooseChooseCourse(){
    $result_info = new ResultInfo();
    $course_id = getCourseID();
    $student_id = getStudentID();
    $flag = checkLoginInfo();

    if($flag){
        $service = new CourseService();
        $flag = $service->findCourseByStudentID($course_id, $student_id);
        if($flag){
            $flag = $service->cancelChooseChooseCourse($course_id, $student_id);   
            if($flag){
                $result_info->setAll($flag, NULL, "成功取消选课");
            }
            else{
                $result_info->setAll($flag, NULL, "取消选课失败");
            }
        }
        else{
            $result_info->setAll(false, NULL, "未选该课程");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

cancelChooseChooseCourse();


?>