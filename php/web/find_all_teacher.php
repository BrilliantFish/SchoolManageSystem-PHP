<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/TeacherService.class.php";

function findAllTeacher(){
    $result_info = new ResultInfo();
    $service = new TeacherService();
    $data = $service->findAllTeacher();

    $result_info->setAll(NULL, $data, "已经查找所有教师");


    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAllTeacher();


?>