<?php
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function notModified($LastModified_unix){ // If modified since check and print 304 header
	$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
	$IfModifiedSince = false;
	
	if(ifmsCheck){
		if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
			$IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));  
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
			$IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
		if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
			exit;
		}
	}
	
	header('X-Powered-By: Admin Console CMS ver.5.10.1');
	header('Cache-Control: max-age='.expires.', must-revalidate');
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + expires).' GMT');
	header('Last-Modified: '.$LastModified);
}

#######################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function ifMofifiedSince($file){
	if(ifmsCheck){
		$cached_file= root_path."cache/pages/".$file;
		
		if(file_exists($cached_file)){
			$LastModified_unix = filemtime ( $cached_file );
			notModified($LastModified_unix);
		} 
	} 
}



#######################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */
 function is_frendly_url($mod){
	$db = MysqliDb::getInstance();

	$db->where ("friendly_url", $mod);
	$md_meta = $db->getOne('md_meta');
	
	if(isset($md_meta)) return ($md_meta);
	else return(false);
}

#######################################################################

#######################################################################

function isBot(){
	$bots = array(
		'rambler','googlebot','aport','yahoo','msnbot','turtle','mail.ru','omsktele','yetibot','picsearch','sape.bot','sape_context','gigabot','snapbot','alexa.com','megadownload.net','askpeter.info','igde.ru','ask.com','qwartabot','yanga.co.uk','scoutjet','similarpages','oozbot','shrinktheweb.com','aboutusbot','followsite.com','dataparksearch','google-sitemaps','appengine-google','feedfetcher-google','liveinternet.ru','xml-sitemaps.com','agama','metadatalabs.com','h1.hrn.ru','googlealert.com','seo-rus.com','yadirectbot','yandeg','yandex','yandexsomething','copyscape.com','adsbot-google','domaintools.com','nigma.ru','bing.com','dotnetdotcom','008','abachobot','accoona-ai-agent','addsugarspiderbot','anyapexbot','arachmo','b-l-i-t-z-b-o-t','baiduspider','becomebot','beslistbot','billybobbot','bimbot','bingbot','blitzbot','boitho','btbot','catchbot','cerberian drtrs','charlotte','converacrawler','cosmos','covario ids','diamondbot','discobot','dotbot','earthcom','emeraldshield','envolk[its]spider','esperanzabot','exabot','fast enterprise','fast-webcrawler','fdse robot','findlinks','furlbot','fyberspider','g2crawler','gaisbot','galaxybot','geniebot','girafabot','gurujibot','happyfunbot','hl_ftien_spider','holmes','htdig','iaskspider','ia_archiver','iccrawler','ichiro','igdespyder','irlbot','issuecrawler','jaxified','jyxobot','koepabot','l.webis','lapozzbot','larbin','ldspider','lexxebot','linguee','linkwalker','lmspider','lwp-trivial','mabontland','magpie-crawler','mediapartners','mj12bot','mlbot','mnogosearch','mogimogi','mojeekbot','moreoverbot','morning paper','msrbot','mvaclient','mxbot','netresearchserver','netseer crawler','newsgator','ng-search','nicebot','noxtrumbot','nusearch spider','nutchcvs','nymesis','obot','oegp','omgilibot','omniexplorer_bot','orbiter','pagebiteshyperbot','peew','polybot','pompos','postpost','psbot','pycurl','qseero','radian6','rampybot','rufusbot','sandcrawler','sbider','scrubby','searchsight','seekbot','semanticdiscovery','sensis','seochat','seznambot','shim-crawler','shopwiki','shoula','silk','sitebot','snappy','sogou','sosospider','speedy','sqworm','stackrambler','suggybot','surveybot','synoobot','teoma','terrawizbot','thesubot','thumbnail.cz','tineye','truwogps','turnitinbot','tweetedtimes','twengabot','updated','urlfilebot','vagabondo','voilabot','vortex','voyager','vyu2','webcollage','websquash','wf84','wofindeich','womlpefactory','xaldon_webspider','yacy','yahooseeker','yahooseeker-testing','yandexbot','yandeximages','yandexmetrika','yasaklibot','yeti','yodaobot','yooglifetchagent','youdaobot','zao','zealbot','zspider','zyborg'
	);

	$userAgent= strtolower($_SERVER['HTTP_USER_AGENT']);

	foreach($bots as $bot){
		if(strpos($userAgent,$bot) !== false){
			return true;
		}
	}
	return false;
}


#######################################################################

function getUrl($url){
	$userAgent= $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0';
	$options = ['http' => ['header' => "User-Agent: $userAgent\r\n"]];
	return @file_get_contents($url, 0, stream_context_create( $options ));
}


function getFont($url){
	$response = preg_replace_callback("#(?<=\()(https://\S+)(?=\))#i", function ($matches) {
		return ($response = @file_get_contents(end($matches)))? 'data:application/x-font-'.substr(strrchr(end($matches), '.'), 1).';charset=utf-8;base64,' . base64_encode($response) : '';
	}, getUrl($url));
	
	return $response;
}

?>
