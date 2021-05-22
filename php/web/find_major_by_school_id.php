<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";

function findMajorBySchoolID(){
    $result_info = new ResultInfo();
    $service = new MajorService();
    $data = $service->findMajorBySchoolID($_POST["school_id"]);

    $result_info->setAll(NULL, $data, "");

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findMajorBySchoolID();


?>