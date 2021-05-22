<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassService.class.php";

function findClassByMajorID(){
    $result_info = new ResultInfo();
    $service = new ClassService();
    $data = $service->findClassByMajorID($_POST["major_id"]);

    $result_info->setAll(NULL, $data, "");

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findClassByMajorID();


?>