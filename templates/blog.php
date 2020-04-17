<?php
// Реализация логики блога
// Чанк списка постов с пагинацией - /templates/chanks/blog.php
// Чанк поста - /templates/chanks/blog-item.php

$pageLimit = 2; // Постов на странице раздела, для пагинации

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

// Если есть то отдаем из кэша страницу, и обработаем заголовок if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

############################
if($request_url['path'] == '/blog/' || ctype_digit($page) ) { // Если это раздел блога
	// Запрос страниц
	if( ctype_digit($page) && $page !== false ) { // С пагинацией
		if($page < 1) goto die404;

		$db->where('friendly_url', '/blog/' );
		$md_meta= $db->getOne('md_meta');
		if($db->count < 1) goto die404;
		
		// Установка мета тегов
		$meta_title			= $md_meta['meta_title'];
		$meta_h1			= $md_meta['meta_h1'];
		$meta_description	= $md_meta['meta_description'];
		$meta_keywords		= $md_meta['meta_keywords'];
		$canonical			= siteUrl."/blog/";
		$robots				= "noindex, follow";
		$friendly			= false;

		// set page limit to count results per page. 20 by default
		$db->pageLimit = $pageLimit;
		$blog = $db->arraybuilder()->paginate("md_blog", $page, ['id','friendly_url','meta_title','meta_h1','image','public_time','category','meta_text']);
		if($db->count < 1) goto die404;
		
		$totalPages= $db->totalPages;
		if( $page > $totalPages) goto die404;
		
	} else { // Без пагинации
		$db->orderBy("public_time","Desc");
		$blog= $db->get('md_blog', $pageLimit, ['id','friendly_url','meta_title','meta_h1','image','public_time','category','meta_text']);
		if($db->count < 1) goto die404;
		
		$countItems = $db->getValue("md_blog", "count(*)");
		$totalPages = ceil($countItems / $pageLimit);
		
		$page= 1;
	}
	
	require_once(pages_dir.'chanks/header.php');
	require_once(pages_dir.'chanks/blog.php');
} else {
############################
	if($page){ // Если это страница блога
		$db->where('friendly_url', '/blog/' );
		$md_meta= $db->getOne('md_meta');
		if($db->count < 1) goto die404;
		
		$db->where('friendly_url', $request_url['path'] );
		$md_blog= $db->getOne('md_blog');
		if($db->count < 1) goto die404;
		
		// Установка мета тегов
		$meta_title			= $md_blog['meta_title'];
		$meta_h1			= $md_blog['meta_h1'];
		$meta_description	= $md_blog['meta_description'];
		$meta_keywords		= $md_blog['meta_keywords'];
		$canonical			= siteUrl.$md_blog['friendly_url'];
		$robots				= "index, follow";
		
		if($md_blog['open_graph'] != ''){ // Если есть изображение подключаем Open Graph
			$open_graph= sprintf($o_g, $md_blog['meta_title'], $md_blog['meta_description'], siteUrl.$md_blog['friendly_url'], siteUrl.$md_blog['open_graph'] );
		}
		
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/blog-item.php');
	} else {
die404:
		header("HTTP/1.0 404 Not Found");
		require_once(pages_dir."404.php");
		die();
	}
}

require_once(pages_dir.'chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше




#######################################################################
// Библиотека функций блога

function print_post_category_menu($blog_posts, $request_url){ // Вывод меню категорий в сайдбаре
	// Категории
	$category= [];
	foreach($blog_posts as $v){
		if( !in_array($v['category'],$category) ) $category[]= $v['category'];
	}
	
	foreach($category as $cat){ // Вывод ссылок постов блога, по категориям
		$sub_cat= '';
		$current= false;
		
		foreach($blog_posts as $post){
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
			if($current) 
				printf('<li class="children"><a href="#">%s</a><ul class="sub-menu">%s</ul></li>',
					$cat,$sub_cat
				);
			else 
				printf('<li class="children"><a href="#">%s</a><ul class="sub-menu">%s</ul></li>',
					$cat,$sub_cat
				);
		}
	}
}


function print_pagination_navi($page, $totalPages){ // Вывод пагинации
	echo '<nav aria-label="Блог">';
	echo '<ul class="pagination justify-content-center">';

	if( $page <= 1 ) echo '<li class="page-item disabled"><span class="page-link">Предыдущая</span></li>';
	else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">Предыдущая</a></li>',$page - 1);

	for( $i=1; $i<=$totalPages; $i++){
		if($i == $page) printf('<li class="page-item active"><span class="page-link">%d<span class="sr-only">(текущая)</span></span></li>',$i);
		else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">%d</a></li>',$i,$i);
	}

	if( $totalPages < $page + 1 ) echo '<li class="page-item disabled"><span class="page-link">Следующая</span></li>';
	else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">Следующая</a></li>',$page + 1);

	echo '</ul>';
	echo '</nav>';
}


?>
