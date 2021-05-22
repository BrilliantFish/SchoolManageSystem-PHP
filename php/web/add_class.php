<?php

require_once "check_login_info.php";
require_once "../domain/Major.class.php";
require_once "../domain/Classes.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/MajorService.class.php";
require_once "../service/ClassService.class.php";


//获取前端发送来的专业的表单数据
function getMajorInfo(){
    $major = new Major();
    $major->major_id = $_POST["major_id"];
    $major->major_name = $_POST["major_name"];

    return $major;
}


//建立专业与班级的联系
function addMajorClass($class){
    $major = getMajorInfo();
    $majorService = new MajorService();
    return $majorService->addMajorClass($major, $class);
}

//获取前端发送来的班级的表单数据
function getClassInfo(){   
    $class = new Classes();
    $class->class_id = $_POST["class_id"];
    $class->class_name = $_POST["class_name"];
    $class->class_year = $_POST["class_year"];
    $class->class_number = $_POST["class_number"];

    return $class;
}

function addClass(){
    $result_info = new ResultInfo();
    $class = getClassInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new ClassService();
        $flag = $service->addClass($class);
        if($flag){  
            $flag = addMajorClass($class);
            if($flag){
                $result_info->setAll($flag, $class, "注册成功");
            }
            else{
                $result_info->setAll($flag, $class, "注册成功, 但是学院与专业联系建失败");
            }
            
        }
        else{
            $result_info->setAll($flag, $class, "注册失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

addClass();


?>