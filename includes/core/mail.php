<?php
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */


function sanitize($str){
	if ($str){
		$output = strip_tags($str);
		$output = htmlspecialchars($output);
		return $output;
	}
	else {
		return '';
	}
}

function _mime_content_type($filename) { $result = new finfo(); if (is_resource($result) === true) { return $result->file($filename, FILEINFO_MIME_TYPE); } return false; } 

// https://github.com/Ipatov/SendMailSmtpClass/blob/master/index.php
// http://webi.ru/webi_files/php_libmail.html
// https://snipp.ru/php/class-mail
// 

/* https://gist.github.com/maziukwork/117717afcb93ea6a4702
 * Отправка письма с несколькими вложениями.
 * @param: email - string (адрес получателя)
 * @param: subject - string (тема письма)
 * @param: message - string (тело документа с html тегами)
 * @param: from - string (подсталяется в поле от кого)
 * @param: files - array (массив с файлами)
 * Array
 *	(
 *	    [0] => Array
 *	        (
 *	            [name] => filename.jpg
 *	            [type] => image/jpeg
 *	            [tmp_name] => /var/www/patch/mod-tmp/php8c4Gy0
 *	            [error] => 0
 *	            [size] => 0
 *	        )
 *	
 *	    [1] => Array
 *	        (
 *				...
 *	        )
 *	)
 * 
 * @return: bool (результат работы ф-ции mail)
 */
function send_mail($email, $subject, $message, $from, $files,$path) {
	$headers = '';
	$EOL = "\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
	$boundary = "--".md5(uniqid(time()));  // строка разделитель.
	$filepart = '';

	//Заголовки.
	$headers   .= "MIME-Version: 1.0;$EOL";
	$headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
	$headers   .= "From: $from".$EOL;

	$multipart  = "--$boundary$EOL";
	$multipart .= "Content-Type: text/html; charset=UTF-8$EOL";
	$multipart .= "Content-Transfer-Encoding: base64$EOL";
	$multipart .= $EOL; // раздел между заголовками и телом html-части
	$multipart .= chunk_split(base64_encode($message));

	foreach($files as $file){
		$file= $path.$file;
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
		$filetype = finfo_file($finfo, $file);
		
		$name= basename($file);
		//$file= file_get_contents($file);
		
		$fp = fopen($file,"rb");
		if(!$fp) {
			die(json_encode(['response'=>'Ошибка прикрепления файла']));
		}
		$file= fread($fp, filesize($file));
		fclose($fp);
		
		$filepart .= "$EOL--$boundary$EOL";
		$filepart .= "Content-Disposition: attachment; filename=\"$name\"$EOL";
		$filepart .= "Content-Type: $filetype; name=\"$name\"$EOL";
		$filepart .= "Content-Transfer-Encoding: base64$EOL";
		$filepart .= $EOL; // разделитель между заголовками и телом прикрепленного файла
		$filepart .= chunk_split(base64_encode($file));	
	}
	
	//Добавляем в письмо файлы, если есть.
	$filepart .= "$EOL--$boundary--$EOL";
	$multipart .= $filepart;

	// Отправляем письмо.
	if(mail($email, $subject, $multipart, $headers)) return true;
	return false;
}


?>
