<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/AdminService.class.php";

function findAdminById(){
    $result_info = new ResultInfo();
    $service = new AdminService();
    $flag = $service->findAdminById($_POST["admin_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该用户");
    }
    else{
        $result_info->setAll(true, NULL, "该ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findAdminById();


?>