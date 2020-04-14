<?php
// Замер статистки сервера, вывод в /templates/chanks/footer.php
$time_start = microtime(1);
$memory = memory_get_usage();

// Конфигурация
require_once('includes/config.inc.php');

// Подключение библиотеки функций ядра
foreach (glob("includes/core/*.php") as $filename){
    include $filename;
} 

// Подключение пользовательских функций
require_once('includes/functions.inc.php');


// Подключение шаблона, рендер страницы
if(file_exists(pages_dir.$mod.".php")){
	require_once(pages_dir.$mod.".php");
} else {
	if( $friendly ){
		require_once(pages_dir."friendly.php");
	} else {
		header("HTTP/1.0 404 Not Found");
		require_once(pages_dir."404.php");	
	}
}


?>
