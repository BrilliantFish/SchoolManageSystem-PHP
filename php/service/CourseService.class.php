<?php

require_once "../dao/CourseDao.class.php";
require_once "../domain/PageBean.class.php";

//所有涉及Course表的服务的实现
class  CourseService {  
    var $courseDao;

    function __construct(){
        $this->courseDao = new CourseDao();
    }

    //查找某个学生的各门课的成绩
    function findCourseScore($page_number, $page_size, $student_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        return $this->courseDao->findStudentScore($start, $page_size, $student_id);
    }
    //删除课程
    function deleteCourse($course_id){
        $rows = $this->courseDao->deleteCourse($course_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查找某个学生的各门课
    function findCourseStudent($page_number, $page_size, $student_id){
        $pagebean = new PageBean();

        $total_count = $this->courseDao->countCourseByStudentID($student_id);     //获取总记录数

        $pagebean->setPageNumber($page_number);             //设置当前页码
        $pagebean->setPageSize($page_size);                 //设置每页显示条数
        $pagebean->setTotalCount($total_count);             //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->courseDao->findByPageAndStudentID($start, $page_size, $student_id);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //查找某个学生是否选了这门课
    function findCourseByStudentID($course_id, $student_id){
        $rows = $this->courseDao->findCourseByStudentID($course_id, $student_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //学生选课
    function chooseCourse($course_id, $student_id){
        $rows =  $this->courseDao->chooseCourse($course_id, $student_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //学生取消选择课程
    function cancelChooseChooseCourse($course_id, $student_id){
        $rows =  $this->courseDao->cancelChooseChooseCourse($course_id, $student_id);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //该学生那些课程已经选了
    function findAllChooseCourse($page_number, $page_size, $student_id){
        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $result = $this->courseDao->findByPage($start, $page_size);

        $size = sizeof($result);

        $res = array();
        for($i = 0; $i < $size; $i++){
            $course = $result[$i];
            $course_id = $course["course_id"];
            $flag =  $this->courseDao->findCourseByStudentID($course_id, $student_id);
            $res[] = $flag; 
        }

        return $res;
    }
    //记录成绩
    function recordScore($course_id, $student_id, $score){
        $rows = $this->courseDao->recordScore($course_id, $student_id, $score);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //分页查询
    function pageQuery($page_number, $page_size){
        $pagebean = new PageBean();

        $total_count = $this->courseDao->countCourse();     //获取总记录数

        $pagebean->setPageNumber($page_number);           //设置当前页码
        $pagebean->setPageSize($page_size);               //设置每页显示条数
        $pagebean->setTotalCount($total_count);           //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->courseDao->findByPage($start, $page_size);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //查找所有课程
    function findAllCourse(){
        $pagebean = new PageBean();

        $total_count = $this->courseDao->countCourse();         //获取总记录数          
        $pagebean->setTotalCount($total_count);                 //设置总记录数

        $list = $this->courseDao->findByPage(0, $total_count);
        $pagebean->setList($list);
        
        return $pagebean;
    }
    //添加课程
    function addCourse($course){
        $rows = $this->courseDao->addCourse($course);

        if($rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //查找某个教师的所有课程
    function findCourseTeacher($page_number, $page_size, $teacher_id){
        $pagebean = new PageBean();

        $total_count = $this->courseDao->countCourseByTeacherID($teacher_id);     //获取总记录数

        $pagebean->setPageNumber($page_number);             //设置当前页码
        $pagebean->setPageSize($page_size);                 //设置每页显示条数
        $pagebean->setTotalCount($total_count);             //设置总记录数

        //设置总页数 = 总记录数/每页显示条数
        $total_page = $total_count % $page_size == 0 ? $total_count / $page_size : (int)($total_count / $page_size) + 1 ;
        $pagebean->setTotalPage($total_page);

        $start = ($page_number - 1) * $page_size;       //开始的记录数
        $list = $this->courseDao->findByPageAndTeacherID($start, $page_size, $teacher_id);
        $pagebean->setList($list);
        
        return $pagebean;
    }
}

?>