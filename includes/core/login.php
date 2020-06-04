<?php
function get_xauthtoken(){
	static $xauthtoken;
	if($xauthtoken) return $xauthtoken;
	
	$db = MysqliDb::getInstance();
	if( !isset($_COOKIE['xauthtoken']) ) { // Уникальный xauthtoken
		$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));

		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('xauthtoken', $xauthtoken, time()+60*60*24*365, '/', $domain, false);
	} else {
		$xauthtoken= $db->escape($_COOKIE['xauthtoken']);
	}
	
	return $xauthtoken;
}



function login_xauthtoken($xauthtoken, $reg= false){ // Проверка логина по токену, если нет то регистрация как анонимного, возвращает ID или false
	$db = MysqliDb::getInstance();
	$xauthtoken= $db->escape($xauthtoken);
	
	$db->where("xauthtoken", $xauthtoken);
	$md_users_login = $db->getOne('md_users_login');

	if($db->count > 0) {
		$db->where("id", $md_users_login['user_id']);
		$md_users= $db->getOne('md_users');
		
		if($db->count > 0) {
			return $md_users['id'];
		} else {
			$id= $db->insert('md_users', [
				'role'			=> 0, 
				'login'			=> 'anonymous',
				'name'			=> 'Анонимный'
			]);
			
			$db->where("id", $md_users_login['id'] );
			$db->update('md_users_login', [
				'user_id'		=> $id,
			]);
			
			return $id;
		}
	} else {
		if(!$reg) return false;
		
		$id= $db->insert('md_users', [
			'role'			=> 0, 
			'login'			=> 'anonymous',
			'name'			=> 'Анонимный'
		]);
		
		$db->insert('md_users_login', [
			'xauthtoken'	=> $xauthtoken, 
			'user_id'		=> $id,
			'status'		=> 'anonymous',
			'login_ip'		=> $_SERVER['REMOTE_ADDR']
		]);
		
		return $id;
	}

	return false;
}



function merge_users($deleted_user_id, $authorized_user_id){ // Объединение пользователей в лайках, рейтинге, сообщениях, корзинах, и пр.
	$db = MysqliDb::getInstance();
	
	$db->where('id', $deleted_user_id);
	$db->delete('md_users');
	
	merge_users_like($deleted_user_id, $authorized_user_id);
	merge_users_cart($deleted_user_id, $authorized_user_id);
}




function login_password($login, $password){ // Авторизация по паролю
	// Появляется пустой анонимный пользователь, если авторизация шла с нового браузера
	if($login == 'anonymous' || $password == '' || mb_strlen($password) < 5) return false;
	
	$db = MysqliDb::getInstance();
		
	$xauthtoken= get_xauthtoken();
	$db->where("xauthtoken", $xauthtoken);
	$user_id= $db->getValue('md_users_login', 'user_id');
	
	if($db->count < 1) {
		$user_id= login_xauthtoken($xauthtoken, true);
	}
	
	$login= $db->escape($login);
	if(pepper) $password= hash_hmac("sha256", $password, pepper);
	else $password= md5(md5($password));
	
	$db->where('login', $login);
	$user= $db->getOne('md_users', null, ['id','role','login','password','reg_datetime','name','surname','patronymic','gender','birthday','phone','photo_url','news_check','email_confirmed']);

	if($db->count > 0){
		if(password_verify($password, $user['password'])){ // Password verified
			if( (int)$user['email_confirmed'] != 1 ) return false; 
			
			$db->where("xauthtoken", $xauthtoken);
			$deleted_user_id= $db->getValue('md_users_login', 'user_id');
			
			if( $db->count > 0 && $deleted_user_id != $user['id'] ){  // Удаление дублей анонимных аккаунтов
				merge_users($deleted_user_id, $user['id']);
			}
			
			$db->where("xauthtoken", $xauthtoken);
			$db->update('md_users_login', [
				'user_id'		=> $user['id'],
				'status'		=> 'authorized',
				'login_ip'		=> $_SERVER['REMOTE_ADDR']
			]);
			
			unset($user['password']);
			return $user;
		} else { // Password not correct
			$db->where("xauthtoken", $xauthtoken);
			$db->update('md_users_login', [
				'status' => 'anonymous'
			]);
			
			return false;
		}
	} else { // User not found
		$db->where("xauthtoken", $xauthtoken);
		$db->update('md_users_login', [
			'status' => 'anonymous'
		]);
		
		return false;
	}
}



function login_check(){ // Проверка авторизован ли пользователь
	// Если сессия и статус токена в базе не совпадают, то разлогиниваем!!! может сессия истечь а в базе остаться маркер	
	if( !isset($_SESSION) ||
		!isset($_SESSION['auth']) || 
		!isset($_SESSION['md_users']) ||
		!isset($_SESSION['md_users']['id']) ||  
		$_SESSION['auth'] != 'authorized'
	){
		return false;
	}
	
	$db = MysqliDb::getInstance();

	$xauthtoken= get_xauthtoken();
	$db->where("xauthtoken", $xauthtoken);
	$md_users_login= $db->getOne('md_users_login');

	if( $db->count > 0 &&
		$_SESSION['auth'] == 'authorized' && 
		$_SESSION['md_users']['id'] == $md_users_login['user_id'] && 
		$md_users_login['status'] == 'authorized' 
	){
		return true;
	}
	
	return false;
}



function logout_user(){ // Выход
	// Меняем статус у токена, registered|authorized
	$db = MysqliDb::getInstance();

	if(isset($_SESSION)){
		if(isset($_SESSION['md_users'])) unset($_SESSION['md_users']);
		$_SESSION['auth']= 'registered';
	}

	$xauthtoken= get_xauthtoken();
	$db->where("xauthtoken", $xauthtoken);
	$db->update('md_users_login', [
		'status' => 'registered',
	]);
}



function forgot_password_change($submod, $subpage, $new_password){ // Смена утерянного пароля
	$db = MysqliDb::getInstance();
	$confirm_token= $db->escape($submod);
	
	$db->where('confirm_token', $confirm_token);
	$password= $db->getValue('md_users', 'password');
	if($db->count > 0){
		$time= explode('-',$confirm_token);
		if( is_array($time) && isset($time[1]) ) {
			if( time() > (int)$time[1] + 3600 ) { // Срок действия токена восстановления пароля, можно увеличить до суток
				return false;
			}
		} else {
			return false;
		}
		
		if(pepper) $confirm_str= hash_hmac("sha256", $password, pepper);
		else $confirm_str= md5(md5($password));

		if($confirm_str == $subpage) {
			if(pepper) $new_password= hash_hmac("sha256", $new_password, pepper);
			else $new_password= md5(md5($new_password));
			
			$password_hashed= password_hash($new_password, PASSWORD_DEFAULT);
			
			$db->where('confirm_token', $confirm_token);
			$db->update('md_users', [
				'password'		=> $password_hashed,
				'confirm_token'	=> 0
			]);

			return true;
		}
	}
	
	return false;
}





function get_forgot_password_url($login){ // URL для смены пароля
	$db = MysqliDb::getInstance();
	
	$login= $db->escape($login);
	if($login == 'anonymous') return false;

	$db->where("login", $login);
	$md_users= $db->getOne('md_users');

	if($db->count > 0 && $md_users['email_confirmed'] == '1') {
		if(pepper) $confirm_str= hash_hmac("sha256", $md_users['password'], pepper);
		else $confirm_str= md5(md5($md_users['password']));
		
		$confirm_token= strval(bin2hex(openssl_random_pseudo_bytes(32))).'-'.time();
		
		$db->where("login", $login);
		$db->update('md_users', [
			'confirm_token' => $confirm_token
		]);
		
		return sprintf("%s/profile/forgot/%s/%s/", siteUrl, $confirm_token, $confirm_str);
	}
	
	return false;
}



function is_need_change_password($submod, $subpage){ // Проверка флага операции смены пароля
	$db = MysqliDb::getInstance();
	$confirm_token= $db->escape($submod);
	
	$db->where('confirm_token', $confirm_token);
	$password= $db->getValue('md_users', 'password');
	if($db->count > 0){
		$time= explode('-',$confirm_token);
		
		if( is_array($time) && isset($time[1]) ) {
			if( time() > (int)$time[1] + 3600 ) {
				return false;
			}
		} else {
			return false;
		}
		
		if(pepper) $confirm_str= hash_hmac("sha256", $password, pepper);
		else $confirm_str= md5(md5($password));

		if($confirm_str == $subpage) return true;
	}
	
	return false;
}


function register_user($login, $password, $name, $surname, $patronymic, $gender, $birthday, $phone, $news_check){ // Регистрирует пользователя, false - в случае неудачи
	$db= MysqliDb::getInstance();
	
	$xauthtoken= get_xauthtoken();
	$db->where("xauthtoken", $xauthtoken);
	$md_users_login= $db->getOne('md_users_login');

	if($db->count > 0) {
		$db->where("id", $md_users_login['user_id']);
		$md_users= $db->getOne('md_users');
		
		if($db->count > 0) {
			$user_id= $md_users['id'];
		} else {
			$user_id= login_xauthtoken($xauthtoken, true);
		}
	} else {
		$user_id= login_xauthtoken($xauthtoken, true);
	}
	
	if($user_id){
		if(pepper) $password= hash_hmac("sha256", $password, pepper);
		else $password= md5(md5($password));
		
		$password_hashed= password_hash($password,  PASSWORD_DEFAULT);
		
		$db->where("id", $user_id);
		$db->update('md_users', [
			'role'				=> 0,
			'login'				=> $db->escape($login),
			'password'			=> $password_hashed,
			'name'				=> $db->escape($name),
			'surname'			=> $db->escape($surname),
			'patronymic'		=> $db->escape($patronymic),
			'gender'			=> $db->escape($gender),
			'birthday'			=> $db->escape($birthday),
			'phone'				=> $db->escape($phone),
			'news_check'		=> $db->escape($news_check),
			'photo_url'			=> 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==',
			'email_confirmed'	=> 0
		]);
		
		$db->where("xauthtoken", $xauthtoken);
		$db->update('md_users_login', [
			'user_id' => $user_id
		]);
		
		return true;
	}
	
	return false;
}




function confirm_user_email($submod, $subpage){ // Подтверждение Email при регистрации
	$db = MysqliDb::getInstance();

	$confirm_token= $db->escape($submod);
	
	$db->where('confirm_token', $confirm_token);
	$id= $db->getValue('md_users', 'id');
	if($db->count < 1){
		return false;
	}
	
	$db->where('user_id', $id);
	$md_users_login= $db->getOne('md_users_login');

	if($db->count > 0){
		if(pepper) $confirm_str= hash_hmac("sha256", $md_users_login['xauthtoken'], pepper);
		else $confirm_str= md5(md5($md_users_login['xauthtoken']));

		if($subpage == $confirm_str){ // Проверочный URL совпадает
			$db->where('id', $md_users_login['user_id']);
			$md_users= $db->getOne('md_users');
			
			if($db->count > 0){
				if( (int)$md_users['email_confirmed'] != 1 ){
					$db->where('id', $id);
					$db->update('md_users', [
						'email_confirmed' => 1,
						'confirm_token' => 0
					]);
				} 
				
				return true;
			}
		}
	}
	
	return false;
}


function get_confirm_user_email_url(){  // Возвращает строку подтверждения Email, для отправки на почту, при регистрации пользователя
	$db = MysqliDb::getInstance();
	$xauthtoken= get_xauthtoken();
	$db->where("xauthtoken", $xauthtoken);
	$md_users_login = $db->getOne('md_users_login');

	if($db->count > 0) {
		if(pepper) $confirm_str= hash_hmac("sha256", $md_users_login['xauthtoken'], pepper);
		else $confirm_str= md5(md5($md_users_login['xauthtoken']));
		
		$confirm_token= strval(bin2hex(openssl_random_pseudo_bytes(32)));
		
		$db->where("id", $md_users_login['user_id']);
		$db->update('md_users', [
			'confirm_token' => $confirm_token
		]);
				
		return sprintf("%s/profile/confirm/%s/%s/", siteUrl, $confirm_token, $confirm_str);
	}
	
	return false;
}


function login_bruteforce_check( $login ){ // Возвращает количество оставшихся попыток
	// Если счетчик нулевой, блокируем на 10 минут
	// После 5 блокировок, если попытки продолжаются то блокировка на сутки
	$db = MysqliDb::getInstance();

	$db->where('login_datetime < (NOW() - INTERVAL 1 DAY)');
	$db->delete('md_users_security');
		
	$login_ip= $db->escape( $_SERVER['REMOTE_ADDR'] );
	$login= $db->escape( $login );

	
	// Проверка брута с разных ip, например через tor
	$db->where("login", $login );
	$attempts= $db->getValue('md_users_security', "count(*)");
	if($db->count < 1) {
		$db->where("login_ip", $login_ip);
		$attempts= $db->getValue('md_users_security', "count(*)");
		if($db->count < 1) $attempts= 0;
	}


	$db->where("login_ip", $login_ip);
	$md_users_security= $db->getOne('md_users_security');
	
	if($db->count > 0) {
		$retry= (int)$md_users_security['retry'];
		$recidive= (int)$md_users_security['recidive'];
		$login_datetime= strtotime($md_users_security['login_datetime']);
		
		if( time() > $login_datetime + 600 && $retry == 0 ) {
			if( $recidive - 1 > 0  ) {
				$recidive--;
				$retry= 5;
			} else {
				$recidive= 0;
			}
		}
		
		if( $retry - 1 < 1  ) {
			$retry= 0;
		} else {
			$retry--;
		}
		
		if($attempts > 4) {
			$retry= 0;
			$recidive= 0;
		}

		$db->where("id", (int)$md_users_security['id'] );
		$db->update('md_users_security', [
			'retry' => $retry,
			'recidive' => $recidive
		]);
		
		return $retry;
	} else {
		if($attempts > 4) $retry= 0;
		else $retry= 4;
		
		$db->insert('md_users_security', [
			'login'	=> $login,
			'login_ip' => $db->escape( $_SERVER['REMOTE_ADDR'] ),
			'retry' => $retry,
			'recidive' => 5
		]);
		return 4;
	}
}


function get_login_block_time(){ // Возвращает строку, время оставшейся блокировки
	$db = MysqliDb::getInstance();

	$login_ip= $db->escape( $_SERVER['REMOTE_ADDR'] );

	$db->where("login_ip", $login_ip);
	$md_users_security= $db->getOne('md_users_security');
	
	if($db->count > 0) {
		$retry= (int)$md_users_security['retry'];
		$recidive= (int)$md_users_security['recidive'];
		$login_datetime= strtotime($md_users_security['login_datetime']);
		$arWords = array('минута','минуты','минут');
		
		if( $retry == 0 && $recidive > 0 ) {
			$min= 10 - ceil((time() - $login_datetime) / 60);
			if($min < 1) $min= 1;
			
			$answer= declension_words( $min, $arWords);
			return sprintf("<code>%d</code> %s", $min, $answer);
		}
		
		if( $recidive == 0 ) {
			$min= 1440 - ceil((time() - $login_datetime) / 60);
			if($min < 1) $min= 1;
			
			if( $min > 60 ){
				$min= ceil($min / 60);
				$arWords = array('час','часа','часов');
				$answer= declension_words( $min, $arWords);
				return sprintf("<code>%d</code> %s", $min, $answer);
			} else {
				$answer= declension_words( $min, $arWords);
				return sprintf("<code>%d</code> %s", $min, $answer);
			}
		}
	}
	return false;
}

?>
