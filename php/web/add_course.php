<?php

require_once "check_login_info.php";
require_once "../domain/Classroom.class.php";
require_once "../domain/Course.class.php";
require_once "../domain/Teacher.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassroomService.class.php";
require_once "../service/CourseService.class.php";
require_once "../service/TeacherService.class.php";

//获取前端发送来的教师的表单数据
function getTeacherInfo(){   
    $teacher = new Teacher();
    $teacher->teacher_id = $_POST["teacher_id"];
    $teacher->teacher_name = $_POST["teacher_name"];

    return $teacher;
}

//建立教室与课程的联系
function addTeacherCourse($course){
    $teacherService = new TeacherService();
    $teacher = getTeacherInfo();
    return $teacherService->addTeacherCourse($teacher, $course);
}

//获取前端发送来的教室的表单数据
function getClassroomInfo(){   
    $classroom = new Classroom();
    $classroom->classroom_id = $_POST["classroom_id"];
    $classroom->classroom_name = $_POST["classroom_name"];

    return $classroom;
}

//建立教室与课程的联系
function addClassroomCourse($course){
    $classroomService = new ClassroomService();
    $classroom = getClassroomInfo();
    return $classroomService->addClassroomCourse($classroom, $course);
}

//获取前端发送来的课程的表单数据
function getCourseInfo(){   
    $course = new Course();
    $course->course_id = $_POST["course_id"];
    $course->course_name = $_POST["course_name"];
    $course->course_weekday = $_POST["course_weekday"];
    $course->start_week = $_POST["start_week"];
    $course->end_week = $_POST["end_week"];
    $course->start_time = $_POST["start_time"];
    $course->end_time = $_POST["end_time"];

    return $course;
}

//添加课程
function addCourse(){
    $result_info = new ResultInfo();
    $course = getCourseInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new CourseService();
        $flag = $service->addCourse($course);
        if($flag){
            $flag = addClassroomCourse($course);
            if($flag){
                $flag = addTeacherCourse($course);
                if($flag){
                    $result_info->setAll($flag, NULL, "注册成功, 但是没有与教师建立联系");
                }
                else{
                    $result_info->setAll($flag, NULL, "注册成功");
                }
            }
            else{
                $result_info->setAll($flag, NULL, "注册成功, 但是没有与教师和教室建立联系");
            }
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

addCourse();


?>