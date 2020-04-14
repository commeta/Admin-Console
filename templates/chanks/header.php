<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
	<meta name="description" content="<?php echo $meta_description; ?>" />
    <link rel="shortcut icon" href="<? echo siteUrl;?>/favicon.ico" type="image/x-icon" />
	<title><?php echo $meta_title; ?></title>
	<link href="<?php echo $canonical; ?>" rel="canonical" />
	<meta name="robots" content="<?php echo $robots; ?>" />
	
<?php
// массив с путями до css файлов
$css_array = array(
    'css/bootstrap.min.css',
    'css/carousel.css',
    'css/style.css',
);
// вызываем функцию сжатия
compression_css_files($css_array, "css/dyn/header-dynamic-modules.css", "css/dyn/header-fonts.css", true);
?>

  </head>
  <body>
	<header>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"> <a class="navbar-brand" href="/">Admin Console</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
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
					<li class="nav-item"> <a class="nav-link" href="/sitemap.xml">sitemap</a> </li>
					<li class="nav-item"> <a class="nav-link disabled" href="/404.html">404</a> </li>
				</ul>
				<form class="form-inline mt-2 mt-md-0" action="/admin/login.php" method="post" >
					<input class="form-control mr-sm-2" type="text" placeholder="admin" value="admin" >
					<input class="form-control mr-sm-2" type="text" placeholder="password" value="password" >
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">войти</button>
				</form>
			</div>
		</nav>
	</header>
    <main role="main" class="container">
