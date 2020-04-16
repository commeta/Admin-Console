<?php
session_start();
require_once('../includes/config.inc.php');

// Подключение библиотеки функций ядра
foreach (glob("../includes/core/*.php") as $filename){
    include $filename;
} 

// Подключение библиотеки функций ядра админки
foreach (glob("core/*.php") as $filename){
    include $filename;
} 

if (isset($_SESSION['xauthtoken'])) {
	$db = MysqliDb::getInstance();
	$xauthtoken = $db->escape($_SESSION['xauthtoken']);
	
	$db->where('xauthtoken',$xauthtoken );
	$db->delete('md_users_login');
	
	unset($_SESSION['xauthtoken']);
}

header ("location: /admin/login.php");
?>
