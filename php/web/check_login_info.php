<?php

function checkLoginInfo(){
    session_start();
    $cookie_user_id = $_COOKIE["user_id"];
    $cookie_user_password = $_COOKIE["user_password"];
    $session_user_id = $_SESSION["user_id"];
    $session_user_password = $_SESSION["user_password"];

    if(isset($cookie_user_id) && isset($cookie_user_password) && isset($session_user_id) && isset($session_user_password)){
        if(($cookie_user_id == $session_user_id) && ($cookie_user_password == $session_user_password)){
            return true;
        }
        else {
            return false;
        }
    }
    else{
        false;
    }
}

?>