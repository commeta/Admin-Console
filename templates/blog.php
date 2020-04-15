<?php

$o_g=<<<OPEN_GRAPH
<meta property="og:type" content="website">
<meta property="og:site_name" content="Admin Console">
<meta property="og:title" content="%s">
<meta property="og:description" content="%s">
<meta property="og:url" content="%s">
<meta property="og:locale" content="ru_RU">
<meta property="og:image" content="%s">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
OPEN_GRAPH;



if($page){ // Если это страница
	$db->where('friendly_url', $request_url['path'] );
	$md_blog= $db->getOne('md_blog');
	
	if($db->count < 1){
		header("HTTP/1.0 404 Not Found");
		require_once(pages_dir."404.php");
		die();
	}
	
	$db->where('friendly_url', '/blog/' );
	$md_meta= $db->getOne('md_meta');
	
	$meta_title			= $md_blog['meta_title'];
	$meta_h1			= $md_blog['meta_h1'];
	$meta_description	= $md_blog['meta_description'];
	$meta_keywords		= $md_blog['meta_keywords'];
	$canonical			= siteUrl.$md_blog['friendly_url'];
	$robots				= "index, follow";
	
	if($md_blog['open_graph'] != ''){ // Если есть изображение подключаем Open Graph
		$open_graph= sprintf($o_g, $md_blog['meta_title'], $md_blog['meta_description'], siteUrl.$md_blog['friendly_url'], siteUrl.$md_blog['open_graph'] );
	}
}

// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

if($request_url['path'] == '/blog/') { // Если это раздел
	require_once(pages_dir.'chanks/header.php');
	require_once(pages_dir.'chanks/blog.php');
} else {
	if($page){ // Если это страница
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/blog-item.php');
	} else {
		header("HTTP/1.0 404 Not Found");
		require_once(pages_dir."404.php");
		die();
	}
}

require_once(pages_dir.'chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше

?>
