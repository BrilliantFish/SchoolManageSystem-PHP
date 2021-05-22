<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/TeacherService.class.php";

function findTeacherCount(){
    $result_info = new ResultInfo();
    $service = new TeacherService();
    $data = $service->findTeacherCount($_POST["year"]);

    $result_info->setAll(NULL, $data, NULL);

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findTeacherCount();


?>