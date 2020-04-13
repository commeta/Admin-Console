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
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"> <a class="navbar-brand" href="#">Carousel</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active"> <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> </li>
					<li class="nav-item"> <a class="nav-link" href="#">Link</a> </li>
					<li class="nav-item"> <a class="nav-link disabled" href="#">Disabled</a> </li>
				</ul>
				<form class="form-inline mt-2 mt-md-0">
					<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav>
	</header>
    <main role="main" class="container">
