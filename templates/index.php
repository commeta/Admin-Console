<?php
# Реализация логики главной страницы

// Если есть то отдаем из кэша страницу, и обработаем заголовок if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

$db->where("parent_id",$md_meta['meta_id']); // Запрос изображений из БД
$md_meta_img= $db->get("md_meta_img", null, ['id','img_url','img_alt','img_size']);

$slider = array_filter($md_meta_img, function($k) { // Изображения для слайдера
	return $k['img_size'] == 'slider';
});

require_once('chanks/header.php');
?>
<main role="main" class="">

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
<?php
foreach($slider as $k=>$slide){
	$active= $k == 0 ? 'class="active"' : '';
	printf('<li data-target="#myCarousel" data-slide-to="%d" %s></li>',$k,$active);
}
?>
		</ol>
		<div class="carousel-inner">
<?php
foreach($slider as $k=>$slide){
	$active= $k == 0 ? 'active' : '';
	echo <<<SLIDE
			<div class="carousel-item {$active}">
				<img class="slide" src="{$slide['img_url']}" alt="{$slide['img_alt']}">
			</div>
	
SLIDE;
}
?>

		</div>
		<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Предыдущий</span> </a>
		<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Следующий</span> </a>
	</div>
	<!-- Marketing messaging and featurettes
			  ================================================== -->
	<!-- Wrap the rest of the page in another container to center all the content. -->
	<div class="container marketing">
<?=$md_meta['meta_text']?>
<?=$md_meta['content']?>
	</div>
	<!-- /.container -->
</main>

<?php
require_once('chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше
?>
