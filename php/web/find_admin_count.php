<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/AdminService.class.php";

function findAdminCount(){
    $result_info = new ResultInfo();
    $service = new AdminService();
    $data = $service->findAdminCount($_POST["year"]);

    $result_info->setAll(NULL, $data, NULL);

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAdminCount();


?>