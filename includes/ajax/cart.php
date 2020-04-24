<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################



########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'save_cart'):
	// Пример обработчика корзины, заглушка!
	session_start(); // Работа с сессиями
	if( !isset($_SESSION['xauthtoken']) ) { // Уникальный xauthtoken
		$_SESSION['xauthtoken'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
	}
	
	//foreach(json_decode($_POST['cart'], true) as $cart){
		//print_r( $cart );
	//}
	
	$_SESSION['cart']= json_decode($_POST['cart'], true);

	die(json_encode($_POST));
endif;


########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'load_cart'):
	// Пример обработчика корзины, заглушка!
	session_start(); // Работа с сессиями
	if( !isset($_SESSION['xauthtoken']) ) { // Уникальный xauthtoken
		$_SESSION['xauthtoken'] = strval(bin2hex(openssl_random_pseudo_bytes(32)));
	} else {
		if(isset($_SESSION['cart'])) die(json_encode(['cart'=>$_SESSION['cart']]));
		
	}

	die(json_encode(['cart'=>'0']));
endif;


?>
