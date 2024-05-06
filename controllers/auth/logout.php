<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    session_unset();
    session_destroy();

    setcookie("user", "", time() - 3600, "/");

    if($_SERVER['HTTP_REFERER']){
        header("Location: ".$_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../index.php");
    }
    exit;
}