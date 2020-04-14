<?php
if( strpos($_SERVER['REQUEST_URI'],'index') !== false && $mod == 'index'){ // Редирект index.(html|php) на /
	header("HTTP/1.1 301 Moved Permanently");
	header( sprintf("Location: %s/",siteUrl) );
	exit();
}

// Запрос URL из базы данных
$db = MysqliDb::getInstance();
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







?>
