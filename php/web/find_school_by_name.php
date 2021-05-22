<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";

function findSchoolByName(){
    $result_info = new ResultInfo();
    $service = new SchoolService();
    $flag = $service->findSchoolByName($_POST["school_name"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该学院");
    }
    else{
        $result_info->setAll(true, NULL, "该学院名称可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findSchoolByName();


?>