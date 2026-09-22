<?php
session_start();
if (!isset($_SESSION['email'])) {
    if(substr( strrchr( $_SERVER['SCRIPT_NAME'] , "/" ) , 1 ) == 'index.php'){
        header("Location: ./auth/login.php");
    }else{
        header("Location: ../auth/login.php");
    }
    exit();
}
?>