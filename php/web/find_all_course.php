<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/CourseService.class.php";

function findAllCourse(){
    $result_info = new ResultInfo();
    $service = new CourseService();
    $data = $service->findAllCourse();

    $result_info->setAll(NULL, $data, "已经查找所有课程");


    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAllCourse();


?>