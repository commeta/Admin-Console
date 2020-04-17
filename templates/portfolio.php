<?php
// Реализация логики портфолио
// Чанк списка постов - /templates/chanks/portfolio.php
// Чанк поста - /templates/chanks/portfolio-item.php


// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

if($request_url['path'] == '/portfolio/') { // Если это раздел
	require_once(pages_dir.'chanks/header.php');
	require_once(pages_dir.'chanks/portfolio.php');
} else {
	if($page){ // Если это страница
		$db->where('friendly_url', '/portfolio/' );
		$md_meta= $db->getOne('md_meta');
		if($db->count < 1) goto die404;
		
		$db->where('friendly_url', $request_url['path'] );
		$md_portfolio= $db->getOne('md_portfolio');
		if($db->count < 1) goto die404;
		
		$meta_title			= $md_portfolio['meta_title'];
		$meta_h1			= $md_portfolio['meta_h1'];
		$meta_description	= $md_portfolio['meta_description'];
		$meta_keywords		= $md_portfolio['meta_keywords'];
		$canonical			= siteUrl.$md_portfolio['friendly_url'];
		$robots				= "index, follow";
		
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/portfolio-item.php');
	} else {
die404:
		header("HTTP/1.0 404 Not Found");
		require_once(pages_dir."404.php");
		die();
	}
}

require_once(pages_dir.'chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше

?>
