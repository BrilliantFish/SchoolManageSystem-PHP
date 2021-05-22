<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";

function findMajorClassCount(){
    $result_info = new ResultInfo();
    $service = new MajorService();
    $data = $service->findMajorClassCount($_POST["major_id"], $_POST["year"]);

    $result_info->setAll(NULL, $data, "");

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findMajorClassCount();


?>