<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################


########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'send_message'):
	// Отправка почты, с файлами
	$name = sanitize($_POST['your-name']);
	$phone = sanitize($_POST['phone']);
	$theme = sanitize($_POST['section']);
	
	$to = email;
	$subject = 'Сообщение с сайта: '.siteUrl;
	
	if(isset($_POST['email']) && $_POST['email'] != '' ) $email= sanitize($_POST['email']);
	else $email=  $to;

	$headers = "From: " . ($email) . "\r\n";
	$headers .= "Reply-To: ". ($email) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	
	if($email == $to) $email= false;
	
	$message = '<html><body>';
	$message .= '<center><h1>Сообщение с сайта '.siteUrl.'</h1></center>';
	$message .= $theme ? 'Тема сообщения: ' . $theme . '<br>' : '';
	$message .= $name ? 'Имя: ' .  $name . '<br>' : '';
	$message .= $email ? 'Почта: ' .  $email . '<br>' : '';
	$message .= $phone ? 'Телефон: ' . $phone . '<br>' : '';
	$message .= !empty($_POST['message']) ? 'Сообщение: ' . sanitize($_POST['message']) . '<br>' : '';
	$message .= 'ip: '.$_SERVER['REMOTE_ADDR'].'<br>';
	$message .= '</body></html>';

	session_start();
	if(isset($_SESSION['xauthtoken'])){
		$id = $db->insert('md_send', [
			'xauthtoken'	=> $db->escape($_SESSION['xauthtoken']), 
			'event_name'	=> $db->escape($theme),
			'ip'			=> $_SERVER['REMOTE_ADDR']
		]);
		
		$path= root_path.'temp/'.$_SESSION['xauthtoken'];
		
		if( file_exists( $path ) && is_dir( $path ) ) { // Если есть файлы для отправки
			$path.='/';
			$files= scandir($path,1);
			unset($files[count($files)-1]);
			unset($files[count($files)-1]);
			
			$ok= send_mail($to, $subject, $message, $email, $files, $path);
			
			if( $ok ) recursiveRemoveDir($path);
		}
	}

	if( !isset($ok) ) $ok= mail($to, $subject, $message, $headers);

	if($ok) $aResult= ['response'=>'Ваше сообщение отправлено!'];
	else $aResult= ['response'=>'Ошибка отправки сообщения!'];

	die(json_encode($aResult));
endif;




########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'send_files'):
	// Загрузка файлов для отправки по почте
	session_start();
	if( !isset($_SESSION['xauthtoken']) ) $_SESSION['xauthtoken']= strval(bin2hex(openssl_random_pseudo_bytes(32)));
	
	$path= root_path.'temp/'.$_SESSION['xauthtoken'];
		
	if ( !file_exists( $path ) && !is_dir( $path ) ) {
		mkdir( $path );       
	}
		
	$path.='/';
	$files      = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){
		$file_name = $file['name'];
		if( move_uploaded_file( $file['tmp_name'], $path.$file_name ) ){
			$done_files[] = $file_name;
		}
	}

	$done_files= scandir($path,1);
	unset($done_files[count($done_files)-1]);
	unset($done_files[count($done_files)-1]);

	die( json_encode( ['files'=>$done_files]) );		
endif;



########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'send_error'):
	// Отлов ошибок из JS frontEnd, log файл: /temp/front-error.log
	file_put_contents(root_path . 'temp/front-error.log', date("H:i:s d.m.Y") . ' ' . $_POST['baseURI']." - ".$_POST['src']."\n", FILE_APPEND );

	die(json_encode([]));
endif;




########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'checkout'):
	// Пример обработчика корзины, заглушка!
	session_start(); // Работа с сессиями
	if( !isset($_SESSION['xauthtoken']) ) { // Уникальный xauthtoken
		$_SESSION['xauthtoken'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
	}
	

	die(json_encode($_POST));
endif;


?>
