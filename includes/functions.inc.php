<?php
if( strpos($_SERVER['REQUEST_URI'],'index') !== false && $mod == 'index'){ // Редирект index.(html|php) на /
	header("HTTP/1.1 301 Moved Permanently");
	header( sprintf("Location: %s/",siteUrl) );
	exit();
}

// Запрос URL из базы данных
$db = MysqliDb::getInstance();
$db->setTrace(true);

$request_url['path']= $db->escape($request_url['path']);
if($mod == 'index') $request_url['path']= '/index.html';

$db->where('friendly_url', $request_url['path'] );
$md_meta= $db->getOne('md_meta');

if($db->count > 0){ // Подготовка мета тегов
	$meta_title			= $md_meta['meta_title'];
	$meta_h1			= $md_meta['meta_h1'];
	$meta_description	= $md_meta['meta_description'];
	$meta_keywords		= $md_meta['meta_keywords'];
	
	if($mod == 'index') $canonical= siteUrl.'/';
	else $canonical= siteUrl.$md_meta['friendly_url'];
	
	$robots				= "index, follow";
	$friendly			= true;
} else {
	$meta_title			= "";
	$meta_h1			= "";
	$meta_description	= "";
	$meta_keywords		= "";
	$canonical			= siteUrl.'/';
	$robots				= "noindex, follow";
	$friendly			= false;
}

########################################################################


function print_server_stat($id,$time_start,$memory){ // Вывод статистки сервера
	// БД
	$db = MysqliDb::getInstance();
	$db_trace= $db->trace;
	$db_time= 0;
	$db_count= 0;

	foreach($db_trace as $v){
		$db_time= $db_time + $v[1];
		$db_count++;
	}

	// Время выполнения
	$time_end = microtime(1);
	$time = $time_end - $time_start; 

	// Использование памяти
	$memory = memory_get_usage() - $memory;
	// Конвертация результата в килобайты и мегабайты 
	$i = 0;
	while (floor($memory / 1024) > 0) {
		$i++;
		$memory /= 1024;
	}
	$name = array('байт', 'КБ', 'МБ');

	printf('<script>document.getElementById("%s").innerHTML= "Страница была сгенерирована за: %s сек. Выполнено: %s запросов к БД за %s сек. Использовано: %s памяти";</script>',
		$id,
		round($time,5),
		$db_count,
		round($db_time,5),
		round($memory, 2) . ' ' . $name[$i]
	);
}




?>
