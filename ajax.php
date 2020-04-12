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

// Подключение пользовательских функций
require_once('includes/functions.inc.php');

// Подключение библиотеки обработчиков ajax запросов
foreach (glob("includes/ajax/*.php") as $filename){
    include $filename;
} 


?>
