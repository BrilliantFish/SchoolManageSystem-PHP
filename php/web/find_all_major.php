<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";

function findAllMajor(){
    $result_info = new ResultInfo();
    $service = new MajorService();
    $data = $service->findAllMajor();

    $result_info->setAll(NULL, $data, "已经查找所有专业");


    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAllMajor();


?>