<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";

function findMajorById(){
    $result_info = new ResultInfo();
    $service = new MajorService();
    $flag = $service->findMajorById($_POST["major_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该专业ID");
    }
    else{
        $result_info->setAll(true, NULL, "该专业ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findMajorById();


?>