<?php

require_once "check_login_info.php";
require_once "../domain/Classes.class.php";
require_once "../domain/Student.class.php";
require_once "../domain/ResultInfo.class.php";
require_once "../service/ClassService.class.php";
require_once "../service/StudentService.class.php";


//获取前端发送来班级的表单数据
function getClassInfo(){         
    $class = new Classes();
    $class->class_id = $_POST["class_id"];
    $class->class_name = $_POST["class_name"];

    return $class;
}


//建立班级与学生的联系
function addClassStudent($student){
    $class = getClassInfo();
    $classService = new ClassService();
    $flag = $classService->addClassStudent($class, $student);

    return $flag;
}


//获取前端发送来学生的表单数据
function getStudentInfo(){         
    $student = new Student();
    $student->student_id = $_POST["student_id"];
    $student->student_password = $_POST["student_password"];
    $student->id_number = $_POST["id_number"];
    $student->student_name = $_POST["student_name"];
    $student->sex = $_POST["sex"];                       //性别
    $student->start_year = $_POST["begin_year"];         //入学年份 
    $student->study_status = $_POST["study_status"];     //1-就读，2-毕业，0=退学
    $student->birthday = $_POST["birthday"];
    $student->country = $_POST["country"];
    $student->address = $_POST["address"];
    $student->tellphone = $_POST["tellphone"];

    return $student;
}

function addStudent(){
    $result_info = new ResultInfo();
    $student = getStudentInfo();
    $flag = checkLoginInfo();

    if($flag){
        $service = new StudentService();
        $flag = $service->addStudent($student);
        if($flag){
            $flag = addClassStudent($student);
            if($flag){
                $result_info->setAll($flag, $flag, "注册成功");
            }  
            else{
                $result_info->setAll($flag, $flag, "注册成功, 但是建立班级与学生的联系时失败");
            }
        }
        else{
            $result_info->setAll($flag, $flag, "注册失败");
        }
    }
    else{
        $result_info->setAll($flag, NULL, "未登录");
    }

    echo json_encode($result_info, JSON_UNESCAPED_UNICODE);
}

addStudent();

?>