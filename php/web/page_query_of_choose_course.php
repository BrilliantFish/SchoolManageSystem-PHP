<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/CourseService.class.php";

//获取当前登录学生的ID
function getStudentID(){
    session_start();
    return $_SESSION["user_id"];
}

//分页查询所有课程，并获取对应课程是否该学生已选
function coursePageQuery(){
    $student_id = getStudentID();
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $page_number = $_POST["page_number"];
    $page_size =$_POST["page_size"];

    if($flag){
        $service = new CourseService();

        //处理参数
        if(!(isset($page_number) && $page_number != "" && $page_number != NULL)){
            $page_number = 1;   //当前页码，如果不传递，则默认为第一页
        }
        if(!(isset($page_size) && $page_size != "" && $page_size != NULL)){
            $page_size = 9;     //每页显示条数，如果不传递，默认每页显示5条记录
        }
        $data = $service->pageQuery($page_number, $page_size);
        $choosed_course_id = $service->findAllChooseCourse($page_number, $page_size, $student_id);

        $result_info->setAll($flag, $data, $choosed_course_id);
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

coursePageQuery();

?>