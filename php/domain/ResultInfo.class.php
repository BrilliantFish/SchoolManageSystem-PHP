<?php

//数据库不存在ResultInfo表，
//创建ResultInfo类是为了更好地向前端传递后端处理数据的结果，是成功还是失败
//ResultInfo类
class ResultInfo {
    var $flag;            //后端返回结果正常为true，发生异常返回false
    var $data;            //后端返回结果数据对象
    var $errorMsg;        //发生异常的错误消息

    function setFlag($flag){
        $this->flag = $flag;
    }

    function setData($data){
        $this->data = $data;
    }
    function setErrorMsg($errorMsg){
        $this->errorMsg = $errorMsg;
    }
    function setAll($flag, $data, $errorMsg){
        $this->flag = $flag;
        $this->data = $data;
        $this->errorMsg = $errorMsg;
    }
}

?>