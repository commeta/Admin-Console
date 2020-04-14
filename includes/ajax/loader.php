<?php

if(isset($_POST['oper']) && $_POST['oper'] == 'multi-loader'):
	header('Content-type: application/json');
	
	if(isset($_POST['userAgent'])){
		if($_POST['userAgent'] == "" && strpos($_POST['userAgent'],"Lighthouse") !== false ) die();
		if(isBot()) die();
		if(strpos($_POST['chunks'],'..') !== false) die();
		if(strpos($_SERVER['HTTP_REFERER'],siteUrl) !== 0) die();
		
		if(isset($_POST['chunks'])){
			$response= [];
			$chunks= explode(',',rtrim($_POST['chunks'],','));
			
			foreach($chunks as $chunk){
				if(file_exists("sliders/".$chunk.".html")){
					$chunk_content= file_get_contents("sliders/".$chunk.".html");
					$response[$chunk]= $chunk_content;
				}
			}
			
			die(json_encode($response));
		}
	}
endif;



if(isset($_POST['oper']) && $_POST['oper'] == 'get_font'):
	$userAgent= $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:73.0) Gecko/20100101 Firefox/73.0';
	header("Content-type: text/css");
	
	if($userAgent == "" && strpos($userAgent,"Lighthouse") !== false ) die();
	if(isBot()) die();
	if(strpos($_SERVER['HTTP_REFERER'],siteUrl) !== 0) die();
	
	$uaMD5= md5($userAgent);
	
	if( file_exists(root_path."cache/fonts/".$uaMD5.".css") ){
		die( file_get_contents(root_path."cache/fonts/".$uaMD5.".css") );
	}
	
	$font= getFont(googleFont);
	if(folder_exist(root_path."cache/fonts") === false) @mkdir(root_path."cache/fonts");
	
	file_put_contents(root_path."cache/fonts/".$uaMD5.".css", "/* $userAgent */\n$font");
	
	die( $font );
endif;




?>
