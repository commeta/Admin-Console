<?php
########################################################################
function strip_comments($html){
	global $request_url;
	
    $html = str_replace(array("\r\n<!--", "\n<!--"), "<!--", $html);
    while(($pos = strpos($html, "<!--")) !== false)    {
        if(($_pos = strpos($html, "-->", $pos)) === false) $html = substr($html, 0, $pos);
        else $html = substr($html, 0, $pos) . substr($html, $_pos+3);
    }
    
    $html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $html);
	$html = str_replace(array("\r\n\r\n", "\r\r", "\n\n"), "\n", $html);
	$html = str_replace(array("\t","\r"), ' ', $html);
	$html = str_replace(array(">\n"), '>', $html);
	$html = preg_replace('/ {2,}/', ' ', $html);
	$html = preg_replace('![ \t]*// .*[ \t]*[\r\n]!', '', $html);
	
	$html = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $html);
	
	if($request_url['path'] == '/index.html') $html = str_replace( 'href="/"', 'href="'.'javascript:'.'"', $html);
	else $html = str_replace( 'href="'.$request_url['path'].'"', 'href="'.'javascript:'.'"', $html);

	$html = str_replace('src="/', 'src="'.siteUrl.'/', $html);
	$html = str_replace("src='/", "src='".siteUrl.'/', $html);
	
	$html = str_replace('href="/', 'href="'.siteUrl.'/', $html);
	$html = str_replace('href="/', 'href="'.siteUrl.'/', $html);
	
    return $html;
}

// wget -r -l 7 -p -nc -nd --spider -q --reject=png,jpg,jpeg,ico,xml,txt,ttf,woff,woff2,pdf,eot,eot?,eot%3F,gif,svg,mp3,ogg,mpeg,avi,zip,gz,bz2,rar,swf,otf https://webdevops.ru/

########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */
function validate_url($link) {
  $link = trim($link);
  $pattern = '/^((?:https?\:)?(?:\/{2})?)?((?:[\w\d-_]{1,64})\.(?:[\w\d-_\.]{2,64}))(\:\d{2,6})?((?:\/|\?|#|&){1}(?:[\w\d\S]+)?)?$/u';
  preg_match($pattern, $link, $matches);

  if ($matches) {
    unset($matches[0]);

    $matches[1] = $matches[1] ?: '//';
    $count = count($matches);

    $matches = array_filter($matches, function ($v) use ($link, $count) {
      return trim($v);
    });
  }

  return $matches;
}


/**
*   Функция для сжатия CSS файлов
*   Удаляет комментарии, табуляцию, переходы на новую строку и повторяющиеся пробелы
*   А также собирает все файлы в один
*
*   @var $files_css array  - массив путей до css файлов, которые необходимо сжать
*   @var $new_file  string - путь, куда будет сохранен сжатый файл
*
*   @return bool - результат
*/
function compression_css_files($files_css, $new_file, $font_file, $compress= false) {
	if(cachePageAndDB){
		// Проверяем время создания, для валидации кэша
		$f_compressed_time= 0;
		
		if(file_exists($new_file)){
			$f_compressed_time= filemtime($new_file);
		}
		
		foreach($files_css as $one_file){
			if(file_exists($one_file)){
				$f_css_time= filemtime($one_file);
				if($f_css_time > $f_compressed_time) {
					$compress= true;
					break;
				}
			}
		}
		
		if($compress){
			// получаем содержимое всех css файлов
			$content_css = "";
			foreach($files_css as $one_file){ // фильтры css: пути от корня, склейка, 	
				$cln= str_replace("url(../", "url(".siteUrl."/".dirname($one_file)."/../",  @file_get_contents($one_file)  );
				$cln= str_replace("url('../", "url('".siteUrl."/".dirname($one_file)."/../",  $cln  );
				$cln= str_replace('url("../', 'url("'.siteUrl.'/'.dirname($one_file)."/../",  $cln  );
				
				$cln= str_replace("url(fonts/", "url(".siteUrl."/".dirname($one_file)."/fonts/",  $cln  );
				$cln= str_replace("url('fonts/", "url('".siteUrl."/".dirname($one_file)."/fonts/",  $cln  );
				$cln= str_replace('url("fonts/', 'url("'.siteUrl.'/'.dirname($one_file)."/fonts/",  $cln  );
				
				$cln= str_replace("url(software/", "url(".siteUrl."/".dirname($one_file)."/software/",  $cln  );
				$cln= str_replace("url('software/", "url('".siteUrl."/".dirname($one_file)."/software/",  $cln  );
				$cln= str_replace('url("software/', 'url("'.siteUrl.'/'.dirname($one_file)."/software/",  $cln  );
				
				$cln= str_replace("url(ecommerce/", "url(".siteUrl."/".dirname($one_file)."/ecommerce/",  $cln  );
				$cln= str_replace("url('ecommerce/", "url('".siteUrl."/".dirname($one_file)."/ecommerce/",  $cln  );
				$cln= str_replace('url("ecommerce/', 'url("'.siteUrl.'/'.dirname($one_file)."/ecommerce/",  $cln  );
				
				$cln= str_replace("url(music/", "url(".siteUrl."/".dirname($one_file)."/music/",  $cln  );
				$cln= str_replace("url('music/", "url('".siteUrl."/".dirname($one_file)."/music/",  $cln  );
				$cln= str_replace('url("music/', 'url("'.siteUrl.'/'.dirname($one_file)."/music/",  $cln  );
				
				$cln= str_replace("url(arrows/", "url(".siteUrl."/".dirname($one_file)."/arrows/",  $cln  );
				$cln= str_replace("url('arrows/", "url('".siteUrl."/".dirname($one_file)."/arrows/",  $cln  );
				$cln= str_replace('url("arrows/', 'url("'.siteUrl.'/'.dirname($one_file)."/arrows/",  $cln  );
				
				$cln= str_replace("url(basic/", "url(".siteUrl."/".dirname($one_file)."/basic/",  $cln  );
				$cln= str_replace("url('basic/", "url('".siteUrl."/".dirname($one_file)."/basic/",  $cln  );
				$cln= str_replace('url("basic/', 'url("'.siteUrl.'/'.dirname($one_file)."/basic/",  $cln  );
				
				$cln= str_replace("url(basic-elaboration/", "url(".siteUrl."/".dirname($one_file)."/basic-elaboration/",  $cln  );
				$cln= str_replace("url('basic-elaboration/", "url('".siteUrl."/".dirname($one_file)."/basic-elaboration/",  $cln  );
				$cln= str_replace('url("basic-elaboration/', 'url("'.siteUrl.'/'.dirname($one_file)."/basic-elaboration/",  $cln  );
				
				$cln= str_replace("url(weather/", "url(".siteUrl."/".dirname($one_file)."/weather/",  $cln  );
				$cln= str_replace("url('weather/", "url('".siteUrl."/".dirname($one_file)."/weather/",  $cln  );
				$cln= str_replace('url("weather/', 'url("'.siteUrl.'/'.dirname($one_file)."/weather/",  $cln  );
								
				$cln= str_replace("url(/", "url(".siteUrl."/",  $cln  );
				$cln= str_replace("url('/", "url('".siteUrl."/",  $cln  );
				$cln= str_replace('url("/', 'url("'.siteUrl.'/',  $cln  );
								
				$cln= str_replace("url(img/", "url(".siteUrl."/".dirname($one_file)."/img/",  $cln  );
				$cln= str_replace("url('img/", "url('".siteUrl."/".dirname($one_file)."/img/",  $cln  );
				$cln= str_replace('url("img/', 'url("'.siteUrl.'/'.dirname($one_file)."/img/",  $cln  );
				
				$cln= str_replace("url(images/", "url(".siteUrl."/".dirname($one_file)."/images/",  $cln  );
				$cln= str_replace("url('images/", "url('".siteUrl."/".dirname($one_file)."/images/",  $cln  );
				$cln= str_replace('url("images/', 'url("'.siteUrl.'/'.dirname($one_file)."/images/",  $cln  );
				
				$cln= str_replace("url(wp-content/", "url(".siteUrl."/wp-content/",  $cln  );
				$cln= str_replace("url('wp-content/", "url('".siteUrl."/wp-content/",  $cln  );
				$cln= str_replace('url("wp-content/', 'url("'.siteUrl.'/wp-content/',  $cln  );
				
				$content_css .= $cln;
				
				if(!$content_css) return false; // если какой-то из файлов не получилось прочитать
			}
			 
			// удаляем комментарии 
			$content_css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content_css);
			// удаляем табуляции и переходы на новую строку
			$content_css = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $content_css);
			// удаляем повторяющиеся пробелы
			$content_css = preg_replace('/ {2,}/', ' ', $content_css);

			$content_css = str_replace(array("\r\n", "\r", "\n", "\t"), '', $content_css);
			$content_css = str_replace(array(" {","{ "," { "), '{', $content_css);
			$content_css = str_replace(array(" }","} "," } "), '}', $content_css);
			$content_css = str_replace(array(" :",": "," : "), ':', $content_css);


			$re = '/@font-face\s*(\{(?:[^{}]+|(?1))*\})/';
			$fontFace= "";
			
			preg_match_all($re, $content_css, $matches, PREG_SET_ORDER);
			
			foreach($matches as $v){
				$fontFace .= $v[0];
				$content_css= str_replace($v[0], "", $content_css);
			}

	// https://webo.in/articles/habrahabr/29-all-about-data-url-images/
	// https://webo.in/articles/habrahabr/46-cross-browser-data-url/
	// https://habr.com/post/116538/
			 
			// сохраняем результат в файл
			$css_file = fopen ($new_file, "w+");  
			fwrite($css_file, $content_css);  
			$result_save = fclose($css_file);
			 
			// сохраняем результат в файл
			$font_file2 = fopen ($font_file, "w+");  
			fwrite($font_file2, $fontFace);  
			$result_save = fclose($font_file2); 
		}
		
		if( filesize($font_file) > 0 ) printf("\n<link rel='stylesheet' href='%s/%s' type='text/css' media='all' />\n",siteUrl,$font_file);
		printf("<link rel='stylesheet' href='%s/%s' type='text/css' media='all' />\n",siteUrl,$new_file);
	} else {
		foreach($files_css as $one_file){
			printf("<link rel='stylesheet' href='%s/%s' type='text/css' media='all' />\n",siteUrl,$one_file);
		}
	}
}

	 

/**
*   Функция для сжатия JS файлов
*   Удаляет комментарии, табуляцию, переходы на новую строку и повторяющиеся пробелы
*   А также собирает все файлы в один
*
*   @var $files_js array  - массив путей до css файлов, которые необходимо сжать
*   @var $new_file  string - путь, куда будет сохранен сжатый файл
*
*   @return bool - результат
*/
function compression_js_files($files_js, $new_file, $compress= false) {
	if(cachePageAndDB){
		// Проверяем время создания, для валидации кэша
		$f_compressed_time= 0;

		if(file_exists($new_file)){
			$f_compressed_time= filemtime($new_file);
		}

		foreach($files_js as $one_file){
			if(file_exists($one_file)){
				$f_css_time= filemtime($one_file);
				if($f_css_time > $f_compressed_time) {
					$compress= true;
					break;
				}
			}
		}

		if($compress){
			// получаем содержимое всех js файлов
			$content_js = "";
			foreach($files_js as $one_file){ // фильтры js: склейка, 	
				$cln= @file_get_contents($one_file);
				$content_js .= $cln."\n";
				
				if(!$content_js) return false; // если какой-то из файлов не получилось прочитать
			}
			 
			// удаляем комментарии 
			$content_js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content_js);

			//  Removes single line '//' comments, treats blank characters
			//$content_js = preg_replace('![ \t]*// .*[ \t]*[\r\n]!', '', $content_js);

			//  Strip blank lines
			//$content_js = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content_js);
			
			//$content_js = str_replace(array("\r\n\r\n", "\r\r", "\n\n"), "\n", $content_js);
			//$content_js = str_replace(array("\t","\r"), ' ', $content_js);

			// удаляем повторяющиеся пробелы
			//$content_js = preg_replace('/ {2,}/', ' ', $content_js);
			 
			// сохраняем результат в файл
			$js_file = fopen ($new_file, "w+");  
			fwrite($js_file, $content_js);  
			$result_save = fclose($js_file); 
		}
		
		printf("<script src='%s/%s'></script>",siteUrl,$new_file);
	} else {
		foreach($files_js as $one_file){
			printf("<script src='%s/%s'></script>\n",siteUrl,$one_file);
		}
	}

}

?>
