<?php
header('Content-Type: application/xml; charset=utf-8');

// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

// Добавить категории и дружественные урл

function sitemap_url_gen($url, $lastmod = '', $changefreq = '', $priority = ''){
//$lastmod - дата последней модификации страницы в формате YYYY-MM-DD (date('Y-m-d') - 2012-02-06)
//$changefreq - как часто обновляется страница. Допустимые значения: always, hourly, daily, weekly, monthly, yearly, never.
//$priority - приоритет страниц. Допустимые значения от наименьшего до наибольшего приоритета: 0.0 - 1.0
	$search = array('&', '\'', '"', '>', '<');
	$replace = array('&amp;', '&apos;', '&quot;', '&gt;', '&lt;');
	$url = str_replace($search, $replace, $url);
	$lastmod = (empty($lastmod)) ? '' : '
	<lastmod>'.$lastmod.'</lastmod>';
	$changefreq = (empty($changefreq)) ? '' : '
	<changefreq>'.$changefreq.'</changefreq>';
	$priority = (empty($priority)) ? '' : '
	<priority>'.$priority.'</priority>';
	$res = '
<url>
	<loc>'.$url.'</loc>'.$lastmod.$changefreq.$priority.'
</url>';
	return $res;
}

	$smp= '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';

$smp.= sitemap_url_gen(sprintf("%s/",siteUrl));
	
$db = MysqliDb::getInstance();

$md_meta = $db->getValue("md_meta","friendly_url", null); // Дружественные URL
foreach($md_meta as $v){
	if($v == '') continue;
	if($v == '/index.html') continue;
	
	$smp.= sitemap_url_gen(
		sprintf("%s%s",siteUrl,$v)
	);
}


$smp.= "\n</urlset>";
header('Content-type: text/xml');
print($smp);

set_cached_page($urlMd5); // Сохраним страницу в кэше
?>
