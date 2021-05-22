<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";

function findAllSchool(){
    $result_info = new ResultInfo();
    $service = new SchoolService();
    $data = $service->findAllSchool();

    $result_info->setAll(NULL, $data, "已经查找所有学院");


    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAllSchool();


?>