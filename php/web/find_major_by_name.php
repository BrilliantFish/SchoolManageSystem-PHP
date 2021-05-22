<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";

function findMajorByName(){
    $result_info = new ResultInfo();
    $service = new MajorService();
    $flag = $service->findMajorByName($_POST["major_name"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该专业名称");
    }
    else{
        $result_info->setAll(true, NULL, "该专业名称可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findMajorByName();


?>