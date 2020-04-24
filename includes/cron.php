<?php
require_once('../includes/config.inc.php');
set_time_limit(20);

// Подключение библиотеки функций ядра
foreach (glob("../includes/core/*.php") as $filename){
    include $filename;
} 
$db = MysqliDb::getInstance();

// Удалить самые старые записи корзин
$db->where("event_time < (NOW() - INTERVAL 30 DAY)");
$db->delete('md_cart');



?>
