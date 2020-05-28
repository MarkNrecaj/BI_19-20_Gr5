<?php
include 'header.php';
$obj->setId(0);
$obj->setExpire(-3600);
$obj->setIsLogin(false);
// $_SESSION['id'] = 0;
// $_SESSION['expire'] = time() - 3600;
// setcookie("is_login", false, time() - 3600);

header('Location: http://localhost/booking/main.php');
