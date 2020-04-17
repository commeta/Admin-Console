<?php
// Менеджер обработки ajax запросов
header('Content-type: application/json');
//header('Access-Control-Allow-Origin: *');

// Конфигурация
require_once('includes/config.inc.php');

// Подключение библиотеки функций ядра
foreach (glob("includes/core/*.php") as $filename){
    include $filename;
} 

// Класс: по работе с базой данных
$db = MysqliDb::getInstance();


// Подключение библиотеки обработчиков ajax запросов
foreach (glob("includes/ajax/*.php") as $filename){
    include $filename;
} 


?>
