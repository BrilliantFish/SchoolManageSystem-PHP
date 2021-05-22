<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassroomService.class.php";

function findAllClassroom(){
    $result_info = new ResultInfo();
    $service = new ClassroomService();
    $data = $service->findAllClassroom();

    $result_info->setAll(NULL, $data, "已经查找所有教室");


    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAllClassroom();


?>