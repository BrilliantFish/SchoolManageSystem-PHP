<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/TeacherService.class.php";

function findTeacherById(){
    $result_info = new ResultInfo();
    $service = new TeacherService();
    $flag = $service->findTeacherById($_POST["teacher_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该教师ID");
    }
    else{
        $result_info->setAll(true, NULL, "该教师ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findTeacherById();


?>