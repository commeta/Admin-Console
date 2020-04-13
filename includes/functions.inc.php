<?php
if( strpos($_SERVER['REQUEST_URI'],'index') !== false && $mod == 'index'){ // Редирект index.(html|php) на /
	header("HTTP/1.1 301 Moved Permanently");
	header( sprintf("Location: %s/",siteUrl) );
	exit();
}

$db = MysqliDb::getInstance();
$request_url['path']= $db->escape($request_url['path']);
if($mod == 'index') $request_url['path']= '/index.html';

$db->where('friendly_url', $request_url['path'] );
$md_meta= $db->getOne('md_meta');

if($db->count > 0){
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







//utm_source=google&utm_campaign=net|{network}|cid|{campaignid}&adposition={adposition}&matchtype={matchtype}&utm_term={keyword}
$utm= [];
if( isset($_GET['utm_source']) ) $utm['utm_source']= $db->escape($_GET['utm_source']);
if( isset($_GET['utm_campaign']) ) $utm['utm_campaign']= $db->escape($_GET['utm_campaign']);
if( isset($_GET['adposition']) ) $utm['adposition']= $db->escape($_GET['adposition']);
if( isset($_GET['matchtype']) ) $utm['matchtype']= $db->escape($_GET['matchtype']);
if( isset($_GET['utm_term']) ) $utm['utm_term']= $db->escape($_GET['utm_term']);

if( $utm && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'http://www.ads.google.com/' && $_SERVER['HTTP_REFERER'] != '') {
	session_start();
	if( !isset($_SESSION['xauthtoken']) ) {
		$_SESSION['xauthtoken'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
	
		$utm['xauthtoken']= $_SESSION['xauthtoken'];
		$utm['url']= 		$db->escape($request_url['path']);
		$utm['ip']= 		$db->escape($_SERVER['REMOTE_ADDR']);
		$utm['referer']= 	$db->escape($_SERVER['HTTP_REFERER']);
		
		$id = $db->insert('md_utm', $utm);
	}
}

if( isset($_SERVER['HTTP_REFERER']) && mb_strpos($_SERVER['HTTP_REFERER'],'yandex.ru') !== false ) {
	session_start();
	if( !isset($_SESSION['xauthtoken']) ) {
		$_SESSION['xauthtoken'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
		
		$utm['xauthtoken']=		$_SESSION['xauthtoken'];
		$utm['utm_source']=		'yandex';
		$utm['utm_term']=		'поисковый запрос';
		$utm['adposition']=		'топ10';
		$utm['utm_campaign']=	'organic';
		$utm['url']=			$db->escape($request_url['path']);
		$utm['ip']=				$db->escape($_SERVER['REMOTE_ADDR']);
		$utm['referer']=		'yandex.ru';
		
		$id = $db->insert('md_utm', $utm);
	}
}

//if( isset($_SERVER['HTTP_REFERER']) ) file_put_contents('temp/referer', $_SERVER['HTTP_REFERER']."\n", FILE_APPEND );


?>
