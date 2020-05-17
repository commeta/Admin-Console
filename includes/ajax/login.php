<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################

// Проверять доступность серверов и ящиков

########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'register'):
	$aResult= ['response'=>'Требуемые поля не заполнены', 'status'=>'error'];

	if( isset($_POST['login']) &&
		isset($_POST['password']) &&
		isset($_POST['password2']) &&
		isset($_POST['name']) &&
		isset($_POST['surname']) &&
		isset($_POST['patronymic']) &&
		isset($_POST['phone'])
	) {
		$login= $_POST['login'];		
		$password= $db->escape($_POST['password']);		
		$password2= $_POST['password2'];		
		$name= $_POST['name'];		
		$surname= $_POST['surname'];		
		$patronymic= $_POST['patronymic'];		
		
		if( $login != check_email($login) ){
			die(json_encode(['response'=>'Не корректный email (логин)', 'status'=>'error']));
		}
		
		$db->where("login", $db->escape($login));
		$md_users= $db->getOne('md_users');

		if($db->count > 0) {
			die(json_encode(['response'=>'Данный email (логин) уже зарегистрирован', 'status'=>'error']));
		}

		if($password == '' || $password != $password2){
			die(json_encode(['response'=>'Пароли не совпадают', 'status'=>'error']));
		}

		if( mb_strlen($password) < 5  ){
			die(json_encode(['response'=>'Слишком короткий пароль! Придумайте пароль не менее 5 символов', 'status'=>'error']));
		}

		$birthday= $_POST['datetimepicker'] ?? '';
		if($birthday){
			$birth= explode('.', $birthday);
			if( is_array($birth) && isset($birth[0]) && isset($birth[1]) && isset($birth[2]) ) {
				foreach($birth as &$birt) $birt = preg_replace("/[^0-9]/", '', $birt);
				$birthday=  sprintf('%s-%s-%s', $birth[2], $birth[1], $birth[0]);
			}
		} else {
			$birthday=  '0000-00-00';
		}

		$news_check= $_POST['news_check'] ?? 0;
		$news_check = preg_replace("/[^0-9]/", '', $news_check);
		
		$gender= $_POST['gender0'] ?? ($_POST['gender0'] ?? 0);
		$gender = preg_replace("/[^0-9]/", '', $gender);
		
		$phone = preg_replace("/[^0-9]/", '', $_POST['phone']);
		
		if( register_user($login, $password, $name, $surname, $patronymic, $gender, $birthday, $phone, $news_check) ){
			if( $confirm_user_email_url= get_confirm_user_email_url() ){
				$theme = 'Подтверждение регистрации пользователя';
				$to = $login;
				$subject = 'Сообщение с сайта: '.siteUrl;
				
				$headers = "From: " . (email) . "\r\n";
				$headers .= "Reply-To: ". (email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				$message = '<html><body>';
				$message .= '<center><h1>Сообщение с сайта '.siteUrl.'</h1></center>';
				$message .= 'Тема сообщения: ' . $theme . '<br>';
				$message .= 'Имя: ' .  $name . '<br>';
				$message .= 'Телефон: ' . $phone . '<br>';
				$message .= 'Сообщение: ' . sprintf('Для завершения регистрации - откройте ссылку в браузере <a href="%s">Подтвердить регистрацию</a><br>', $confirm_user_email_url);
				$message .= '</body></html>';

				$ok= mail($to, $subject, $message, $headers);
				if( $ok ) $aResult= ['response'=>'<h4 class="mb-3">Регистрация завершена!</h4><p>На почту было выслано письмо для подтверждения.</p>', 'status'=>'ok'];
				else $aResult= ['response'=>'Ошибка отправки почты', 'status'=>'error'];
			}
			
			//$aResult= ['response'=>'<h4 class="mb-3">Регистрация завершена!</h4><p>Подтвердите почтовый ящик в личном кабинете.</p>', 'status'=>'ok'];
			
		} else {
			$aResult= ['response'=>'Ошибка! Пользователь не зарегистрирован.', 'status'=>'error'];
		}
	}

	die(json_encode($aResult));
endif;




########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'forgot' && isset($_POST['email'])):
// Если ящик не подтвержден, то выслать сначала подтверждение 

	$login= $db->escape($_POST['email']);
	$aResult= ['response'=>'Ошибка поиска по базе', 'status'=>'error'];
	
	if( $login != check_email($login) ){
		die(json_encode(['response'=>'Не корректный email (логин)', 'status'=>'error']));
	}

	
	$db->where("login", $login);
	$md_users= $db->getOne('md_users');
	if($db->count < 1) {
		die(json_encode(['response'=>'Указанный Email не зарегистрирован', 'status'=>'error']));
	} else {
		if($md_users['email_confirmed'] != '1') die(json_encode(['response'=>'Указанный Email не подтвержден', 'status'=>'error']));
		
		if( $forgot_password_url= get_forgot_password_url($login) ){
			$theme = 'Смена пароля пользователя';
			$to = $login;
			$subject = 'Сообщение с сайта: '.siteUrl;
				
			$headers = "From: " . (email) . "\r\n";
			$headers .= "Reply-To: ". (email) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
				
			$message = '<html><body>';
			$message .= '<center><h1>Сообщение с сайта '.siteUrl.'</h1></center>';
			$message .= 'Тема сообщения: ' . $theme . '<br>';
			$message .= 'Сообщение: ' . sprintf('Для смены пароля - откройте ссылку в браузере <a href="%s">Сменить пароль</a><br> Ссылка действительна в течении одного часа!', $forgot_password_url);
			$message .= '</body></html>';

			$ok= mail($to, $subject, $message, $headers);
			if( $ok ) $aResult= ['response'=>'<h4 class="mb-3">Запрос отправлен!</h4><p>На почту было выслано письмо с инструкциями по смене пароля.</p>', 'status'=>'ok'];
			else $aResult= ['response'=>'Ошибка отправки почты', 'status'=>'error'];
		}
	}

	die(json_encode($aResult));
endif;




########################################################################
if(isset($_POST['oper']) && 
	$_POST['oper'] == 'change_password' && 
	isset($_POST['submod']) && 
	isset($_POST['subpage']) && 
	is_need_change_password($_POST['submod'], $_POST['subpage']) &&
	isset($_POST['password']) && 
	isset($_POST['password2'])
):
	$aResult= ['response'=>'Ошибка смены пароля', 'status'=>'error'];
	
	$password= $db->escape($_POST['password']);		
	$password2= $_POST['password2'];		

	if($password == '' || $password != $password2){
		die(json_encode(['response'=>'Пароли не совпадают', 'status'=>'error']));
	}

	if( mb_strlen($password) < 5  ){
		die(json_encode(['response'=>'Слишком короткий пароль! Придумайте пароль не менее 5 символов', 'status'=>'error']));
	}

	if(forgot_password_change($_POST['submod'], $_POST['subpage'], $password)){
		$aResult= ['response'=>'<h4 class="mb-3">Пароль сменен!</h4><p>Можете зайти в личный кабинет с новым паролем.</p>', 'status'=>'ok'];
	}
	
	die(json_encode($aResult));
endif;



?>
