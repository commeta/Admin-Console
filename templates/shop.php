<?php
# Реализация логики портфолио
# Чанк списка товаров - /templates/chanks/shop.php
# Чанк товара - /templates/chanks/shop-item.php
# Чанк корзины - /templates/chanks/cart-item.php


// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

if($request_url['path'] == '/shop/') { // Если это раздел
	// Запрос всех страниц
	$db->orderBy("public_time","Desc");
	$md_shop= $db->get('md_shop', null, ['id','friendly_url','meta_h1','short','category']);
	if($db->count < 1) goto die404;
	
	// Массив родителей
	$parents = array_column($md_shop, 'id');

	// Запрос изображений нужного формата, из списка родителей
	$db->where('parent_id', $parents, 'in');
	$db->where("(img_type = ? or img_type = ?)", ['gallery','slider']);
	$images= $db->get('md_shop_img', null, ['id','parent_id','img_src','img_alt','img_type'] );
	if($db->count < 1) goto die404;
	
	// Создание массива изображений, с id родителя в качестве ключа
	$img_gallery= []; 
	$img_preview= [];
	foreach($images as $v){
		if($v['img_type'] == 'gallery') $img_gallery[$v['parent_id']]= $v;
		if($v['img_type'] == 'slider') $img_preview[$v['parent_id']]= $v;
	}

	// Создание массива категорий
	$category= [];
	foreach($md_shop as $v){
		if( !in_array($v['category'],$category) ) $category[]= $v['category'];
	}
	
	$db->where('parent_id', $parents, 'in'); // Доп параметры товара
	$md_shop_extended_product= $db->map('parent_id')->ArrayBuilder()->get('md_shop_extended_product', null, ['id','parent_id','cost', 'balance', 'reserved']);
		
	require_once(pages_dir.'chanks/header.php');
	require_once(pages_dir.'chanks/shop.php');
} else {
	if($page){ // Если это страница
		$db->where('friendly_url', '/shop/' );
		$md_meta= $db->getOne('md_meta');
		if($db->count < 1) goto die404;
		
		$db->where('friendly_url', $request_url['path'] );
		$md_shop= $db->getOne('md_shop');
		if($db->count < 1) goto die404;
		
		$meta_title			= $md_shop['meta_title'];
		$meta_h1			= $md_shop['meta_h1'];
		$meta_description	= $md_shop['meta_description'];
		$meta_keywords		= $md_shop['meta_keywords'];
		$canonical			= siteUrl.$md_shop['friendly_url'];
		$robots				= "index, follow";
		
		// Изображения
		$db->where('parent_id', $md_shop['id'] );
		$md_shop_img= $db->get('md_shop_img');
		if($db->count < 1) goto die404;
		
		$screenshot = array_filter($md_shop_img, fn($k) => $k['img_type'] == 'screenshot'); // Изображения для слайдера

		// Навигация Влево - Вправо
		$db->orderBy("public_time","Desc");
		$shop= $db->get('md_shop', null, ['id','friendly_url','meta_h1']);

		$current= array_search($md_shop['id'], array_column($shop, 'id'));
		$count_shop= count($shop);

		if($current > 0) $prev= $current - 1;
		else $prev= $count_shop - 1;

		if($current < $count_shop - 1) $next= $current + 1;
		else $next= 0;

		$db->where("(parent_id = ? or parent_id = ?)", Array($shop[$prev]['id'],$shop[$next]['id']));
		$db->where("img_type","gallery");
		$md_shop_img= $db->get("md_shop_img");
		
		$prev_img= array_search($shop[$prev]['id'], array_column($md_shop_img, 'parent_id'));
		$next_img= array_search($shop[$next]['id'], array_column($md_shop_img, 'parent_id'));

		// Дата
		$public_time= strftime('%B, %Y',strtotime($md_shop['public_time']));		
		
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/shop-item.php');
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
