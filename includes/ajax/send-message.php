<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################


########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
				(
				)
 */


if(isset($_POST['oper']) && $_POST['oper'] == 'send_message'):
	$name = sanitize($_POST['your-name']);
	$phone = sanitize($_POST['phone']);
	$theme = sanitize($_POST['section']);
	
	$to = email;
	//$to= 'dcs-spb@ya.ru';
	
	$subject = 'Сообщение с сайта buydebt.ru';
	
	if(isset($_POST['email']) && $_POST['email'] != '' ) $email= sanitize($_POST['email']);
	else $email=  $to;

	$headers = "From: " . ($email) . "\r\n";
	$headers .= "Reply-To: ". ($email) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	
	if($email == $to) $email= false;
	
	$message = '<html><body>';
	$message .= '<center><h1>Сообщение с сайта buydebt.ru</h1></center>';
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
		
		$root_path = (preg_match('/\/$/',$_SERVER['DOCUMENT_ROOT']))?$_SERVER['DOCUMENT_ROOT']:$_SERVER['DOCUMENT_ROOT'].'/';
		$path= $root_path.'temp/'.$_SESSION['xauthtoken'];
		
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





if(isset($_POST['oper']) && $_POST['oper'] == 'send_files'):
	$root_path = (preg_match('/\/$/',$_SERVER['DOCUMENT_ROOT']))?$_SERVER['DOCUMENT_ROOT']:$_SERVER['DOCUMENT_ROOT'].'/';

	session_start();
	if( !isset($_SESSION['xauthtoken']) ) $_SESSION['xauthtoken']= strval(bin2hex(openssl_random_pseudo_bytes(32)));
	
	if(isset($_SESSION['xauthtoken'])){
		$path= $root_path.'temp/'.$_SESSION['xauthtoken'];
		
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
	}

	die(json_encode([]));
endif;


if(isset($_POST['oper']) && $_POST['oper'] == 'send_error'):
	$root_path = (preg_match('/\/$/',$_SERVER['DOCUMENT_ROOT']))?$_SERVER['DOCUMENT_ROOT']:$_SERVER['DOCUMENT_ROOT'].'/';
	file_put_contents($root_path . '/temp/front-error.log', date("H:i:s d.m.Y") . ' ' . $_POST['baseURI']." - ".$_POST['src']."\n", FILE_APPEND );

	die(json_encode([]));
endif;




if(isset($_GET['oper']) && $_GET['oper'] == 'send_client_id'):
	session_start();
	if(isset($_SESSION['xauthtoken'])){
		$db->where('xauthtoken', $db->escape($_SESSION['xauthtoken']) );
		$db->update('md_utm', [
			'client_id'	=> $db->escape($_GET['client_id'])
		]);
	}
	die(json_encode([]));
endif;

?>
