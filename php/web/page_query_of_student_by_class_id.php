<?php

require_once "check_login_info.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/StudentService.class.php";

function studentPageQuery(){
    $result_info = new ResultInfo();
    $flag = checkLoginInfo();
    $page_number = $_POST["page_number"];
    $page_size = $_POST["page_size"];
    $class_id = $_POST["class_id"];

    if($flag){
        $service = new StudentService();

        //处理参数
        if(!(isset($page_number) && $page_number != "" && $page_number != NULL)){
            $page_number = 1;   //当前页码，如果不传递，则默认为第一页
        }
        if(!(isset($page_size) && $page_size != "" && $page_size != NULL)){
            $page_size = 9;     //每页显示条数，如果不传递，默认每页显示5条记录
        }
        $data = $service->pageQueryByClassID($page_number, $page_size, $class_id);

        $result_info->setAll($flag, $data, "数据查询完成");
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

studentPageQuery();

?>