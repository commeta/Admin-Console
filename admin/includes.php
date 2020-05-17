<?php
require_once('../includes/config.inc.php');
set_time_limit(20);

// Подключение библиотеки функций ядра
foreach (glob("../includes/core/*.php") as $filename){
    include $filename;
} 

// Подключение библиотеки функций ядра админки
foreach (glob("core/*.php") as $filename){
    include $filename;
} 

#######################################################################
$db = MysqliDb::getInstance();

session_start(); // Проверка авторизации
$xauthtoken= get_xauthtoken();
$_SESSION['xauthtoken']= $xauthtoken;

if(login_check() && isset($_SESSION['md_users']['role']) && $_SESSION['md_users']['role'] == 1){
	$user_id= $_SESSION['md_users']['id'];
} else {
	header ("location: /admin/login.php");
	exit;			
}

?>
