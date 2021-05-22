<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";

function findSchoolMajorCount(){
    $result_info = new ResultInfo();
    $service = new SchoolService();
    $data = $service->findSchoolMajorCount($_POST["school_id"]);

    $result_info->setAll(NULL, $data, "");

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findSchoolMajorCount();


?>