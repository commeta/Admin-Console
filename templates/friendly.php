<?php
// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}
$body= "";
require_once('chanks/header.php');
?>


<div class="starter-template">
	<h1><?=$meta_h1?></h1>
	<p class="lead"><?=$md_meta['content']?></p>
</div>

	

<?php
require_once('chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше
?>
