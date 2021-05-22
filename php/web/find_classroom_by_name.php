<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassroomService.class.php";

function findClassroomByName(){
    $result_info = new ResultInfo();
    $service = new ClassroomService();
    $flag = $service->findClassroomByName($_POST["classroom_name"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该教室名称");
    }
    else{
        $result_info->setAll(true, NULL, "该教室名称可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findClassroomByName();


?>