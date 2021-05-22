<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassService.class.php";

function findClassStudentCount(){
    $result_info = new ResultInfo();
    $service = new ClassService();
    $data = $service->findClassStudentCount($_POST["class_id"]);

    $result_info->setAll(NULL, $data, "");

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findClassStudentCount();


?>