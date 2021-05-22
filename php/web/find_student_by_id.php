<?php

require_once "../domain/ResultInfo.class.php";
require_once "../service/StudentService.class.php";

function findStudentrById(){
    $result_info = new ResultInfo();
    $service = new StudentService();
    $flag = $service->findStudentById($_POST["student_id"]);

    if($flag){
        $result_info->setAll(false, NULL, "已存在该学生ID");
    }
    else{
        $result_info->setAll(true, NULL, "该学生ID可以使用");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

findStudentrById();


?>