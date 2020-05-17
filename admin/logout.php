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

$db= MysqliDb::getInstance();
logout_user();
header ("location: /admin/login.php");

?>
