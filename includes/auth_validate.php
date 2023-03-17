<?php
require_once './config/config.php';
if (!isset($_SESSION['user_logged_in'.$session_app]) && $_SESSION['user_logged_in'.$session_app] != TRUE) {
    header('Location:login.php');
}

 ?>