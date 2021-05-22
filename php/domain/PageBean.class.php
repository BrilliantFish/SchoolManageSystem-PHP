<?php

class PageBean{
    var $total_count;   //总记录数
    var $total_page;    //总页数
    var $page_number;   //当前页码
    var $page_size;     //每页显示的条数
    var $list;          //每页显示的数据集合

    function setTotalCount($total_count){
        $this->total_count = $total_count;
    }
    function setTotalPage($total_page){
        $this->total_page = $total_page;
    }
    function setPageNumber($page_number){
        $this->page_number = $page_number;
    }
    function setPageSize($page_size){
        $this->page_size = $page_size;
    }
    function setList($list){
        $this->list = $list;
    }
}

?>