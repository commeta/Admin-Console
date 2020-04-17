<?php
# Реализация логики портфолио
# Чанк списка постов - /templates/chanks/portfolio.php
# Чанк поста - /templates/chanks/portfolio-item.php


// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

if($request_url['path'] == '/portfolio/') { // Если это раздел
	// Запрос всех страниц
	$db->orderBy("public_time","Desc");
	$md_portfolio= $db->get('md_portfolio', null, ['id','friendly_url','meta_h1','short','project']);
	if($db->count < 1) goto die404;
	
	// Массив родителей
	$parents = array_column($md_portfolio, 'id');

	// Запрос изображений нужного формата, из списка родителей
	$db->where('parent_id', $parents, 'in');
	$db->where("(img_size = ? or img_size = ?)", ['gallery','348x225']);
	$images= $db->get('md_portfolio_img', null, ['id','parent_id','img_url','img_alt','img_size'] );
	if($db->count < 1) goto die404;
	
	// Создание массива изображений, с id родителя в качестве ключа
	$img_screenshot= []; 
	$img_preview= [];
	foreach($images as $v){
		if($v['img_size'] == 'gallery') $img_screenshot[$v['parent_id']]= $v;
		if($v['img_size'] == '348x225') $img_preview[$v['parent_id']]= $v;
	}

	// Создание массива категорий
	$category= [];
	foreach($md_portfolio as $v){
		if( !in_array($v['project'],$category) ) $category[]= $v['project'];
	}
		
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
		
		// Изображения
		$db->where('parent_id', $md_portfolio['id'] );
		$md_portfolio_img= $db->get('md_portfolio_img');
		if($db->count < 1) goto die404;
		
		$screenshot = array_filter($md_portfolio_img, function($k) {
			return $k['img_size'] == 'screenshot';
		});

		// Навигация Влево - Вправо
		$db->orderBy("public_time","Desc");
		$portfolio= $db->get('md_portfolio', null, ['id','friendly_url','meta_h1']);

		$current= array_search($md_portfolio['id'], array_column($portfolio, 'id'));
		$count_portfolio= count($portfolio);

		if($current > 0) $prev= $current - 1;
		else $prev= $count_portfolio - 1;

		if($current < $count_portfolio - 1) $next= $current + 1;
		else $next= 0;

		$db->where("(parent_id = ? or parent_id = ?)", Array($portfolio[$prev]['id'],$portfolio[$next]['id']));
		$db->where("img_size","gallery");
		$md_portfolio_img= $db->get("md_portfolio_img");
		
		$prev_img= array_search($portfolio[$prev]['id'], array_column($md_portfolio_img, 'parent_id'));
		$next_img= array_search($portfolio[$next]['id'], array_column($md_portfolio_img, 'parent_id'));

		// Дата
		$public_time= strftime('%B, %Y',strtotime($md_portfolio['public_time']));		
		
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
