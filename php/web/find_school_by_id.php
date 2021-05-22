<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/SchoolService.class.php";

function findSchoolById(){
    $result_info = new ResultInfo();
    $service = new SchoolService();
    $flag = $service->findSchoolById($_POST["school_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该学院ID");
    }
    else{
        $result_info->setAll(true, NULL, "该学院ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findSchoolById();


?>