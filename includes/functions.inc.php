<?php
if( strpos($_SERVER['REQUEST_URI'],'index') !== false && $mod == 'index'){ // Редирект index.(html|php) на /
	header("HTTP/1.1 301 Moved Permanently");
	header( sprintf("Location: %s/",siteUrl) );
	exit();
}

// Класс: по работе с базой данных
// https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#error-helpers

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

// Сессии
session_start();
if( !isset($_COOKIE['xauthtoken']) ) { // Уникальный xauthtoken
	$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
	setcookie('xauthtoken', $xauthtoken, time()+60*60*24*365, '/', $domain, false);
} else {
	$xauthtoken= $_COOKIE['xauthtoken'];
}

$_SESSION['xauthtoken']= $xauthtoken;


########################################################################
// Функции шаблонов

function alias(){ // Алиасы, бета
	global $request_url, $mod, $templates, $md_meta;

	$db = MysqliDb::getInstance();
	$request_url['path']= $db->escape($request_url['path']);
	
	$path_parts = pathinfo($request_url['path']);

	if( $path_parts['dirname'] == '/' ) {
		$alias= str_replace('/','',$path_parts['basename']);
	}
	else {
		$alias= str_replace('/','',$path_parts['dirname']);
	}

	$db->where('alias', $alias ); 
	$templates= $db->getOne('md_templates');
	if($db->count < 1){
		die("templates error");
	}
	
	if( !isset($md_meta) ) {// Алиасы: взять из БД по псевдониму url
		$db->where('friendly_url', "/".$templates['template']."/" );
		$md_meta= $db->getOne('md_meta');
		
		if($db->count < 1){
			die("templates error");
		}
	}
	
	$mod= str_replace('/','',$templates['template']);
	
	if( file_exists( root_path.pages_dir."$mod".".php" ) ){
		return $mod;
	}
	
	return false;
}



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



function print_post_category_menu($posts, $request_url, $md_templates= false){ // Вывод меню категорий в сайдбаре
	// Категории
	$category= [];
	foreach($posts as $v){
		if( !in_array($v['category'],$category) ) $category[]= $v['category'];
	}
	
	foreach($category as $cat){ // Вывод ссылок постов блога, по категориям
		$sub_cat= '';
		$current= false;
		
		foreach($posts as $post){
			if($post['category'] == $cat){
				if($request_url['path'] == $post['friendly_url']){
					$current= true;
					$sub_cat .= sprintf('<li class="current-menu"><a href="%s">%s</a></li>',$post['friendly_url'],$post['meta_h1']);
				} else {
					$sub_cat .= sprintf('<li><a href="%s">%s</a></li>',$post['friendly_url'],$post['meta_h1']);
				}
			}
		}
		
		if( $sub_cat != '' ){
			/*
			if($current){
				printf('<li class="children">%s<ul class="sub-menu">%s</ul></li>',
					$cat,$sub_cat
				);
			}
			*/
			if($md_templates){
				$template = array_filter($md_templates, fn($k) => $k['category'] == $cat);
				
				if(isset($template['blog'])) $url= "/".$template['blog']['alias']."/";
				else $url= "#";
				
				printf('<li class="children"><a href="%s">%s</a><ul class="sub-menu">%s</ul></li>',
					$url,$cat,$sub_cat
				);
			}
			else{
				printf('<li class="children"><a href="#">%s</a><ul class="sub-menu">%s</ul></li>',
					$cat,$sub_cat
				);
			}
		}
	}
}

?>
