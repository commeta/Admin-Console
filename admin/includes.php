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
if(isset($_SESSION['xauthtoken'])){
	$user_id= xauthtokenCheck($_SESSION['xauthtoken']);
} else {
	header ("location: /admin/login.php");
	exit;			
}

?>
