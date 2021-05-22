<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassService.class.php";

function findClassById(){
    $result_info = new ResultInfo();
    $service = new ClassService();
    $flag = $service->findClassById($_POST["class_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该班级ID");
    }
    else{
        $result_info->setAll(true, NULL, "该班级ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findClassById();


?>