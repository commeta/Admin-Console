<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keywords" content="<?=$meta_keywords?>" />
		<meta name="description" content="<?=$meta_description?>" />
		<link rel="shortcut icon" href="<?=siteUrl?>/favicon.ico" type="image/x-icon" />
		<title><?=$meta_title?></title>
		<link href="<?=$canonical?>" rel="canonical" />
		<meta name="robots" content="<?=$robots?>" />
	
<?php
// массив с путями до css файлов
$css_array = [
    'css/bootstrap.min.css',
    'css/carousel.css',
    'css/blog.css',
    'css/jquery.fancybox.min.css',
    'css/isotope.css',
    'css/flexslider.css',
    //'css/flexslider-rtl-min.css',
    'css/jquery.datetimepicker.css',
    'css/style.css',
];
// вызываем функцию сжатия
compression_css_files($css_array, "css/dyn/header-dynamic-modules.css", "css/dyn/header-fonts.css", true);
?>

	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"> 
				<a class="navbar-brand" href="/">Admin Console</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto">
<?php
if( $md_meta['friendly_url'] == '/index.html' )
	printf('<li class="nav-item active"> <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a> </li>');
else
	printf('<li class="nav-item"> <a class="nav-link" href="/">Главная</a> </li>');

$menu = $db->get("md_meta", null, ["friendly_url","meta_h1"]); // Дружественные URL
foreach($menu as $v){
	if($v['friendly_url'] == '' && $v['meta_h1']) continue;
	if($v['friendly_url'] == '/index.html') continue;
	if( $md_meta['friendly_url'] == $v['friendly_url'] )
		printf('<li class="nav-item active"> <a class="nav-link" href="%s">%s</a> </li>',$v['friendly_url'],$v['meta_h1']);
	else
		printf('<li class="nav-item"> <a class="nav-link" href="%s">%s <span class="sr-only">(current)</span></a> </li>',$v['friendly_url'],$v['meta_h1']);
}
?>


						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Системные</a>
							<div class="dropdown-menu" aria-labelledby="dropdown01">
								<a class="dropdown-item" href="/sitemap.xml">sitemap</a>
								<a class="dropdown-item" href="/404.html">404</a>
							</div>
						</li>
					</ul>
					
					
					
					<a class="nav-link" id="cart-link" href="#">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
						<span id="cart">0</span>
					</a>					


<?php

if( login_check() ){ // Для залогиненных
	$login_form=<<<LOGIN_FORM
					<form class="form-inline mt-2 mt-md-0" action="/profile/" method="post" >
						<input type="hidden" name="logout" value="logout" >
						<a class="nav-link" href="/profile/">{$_SESSION['md_users']['name']}</a>
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">выйти</button>
					</form>
LOGIN_FORM;
} else {
	$login_form=<<<LOGIN_FORM
					<form class="form-inline mt-2 mt-md-0" action="/profile/" method="post" >
						<input class="form-control mr-sm-2" type="text" name="login" value="" >
						<input class="form-control mr-sm-2" type="password" name="password" value="" >
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">войти</button>
					</form>
LOGIN_FORM;
}

echo $login_form;
?>


				</div>
			</nav>
		</header>
