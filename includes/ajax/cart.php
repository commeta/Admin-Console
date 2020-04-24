<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################



########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'save_cart'):
	// Пример обработчика корзины, заглушка!
	
	if( !isset($_COOKIE['xauthtoken']) ) { // Уникальный xauthtoken
		$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));

		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('xauthtoken', $xauthtoken, time()+60*60*24*365, '/', $domain, false);
	} else {
		$xauthtoken= $db->escape($_COOKIE['xauthtoken']);
	}

	$cart= json_decode($_POST['cart'], true);
	$cart= serialize($cart);

	$db->where("xauthtoken", $xauthtoken);
	$md_cart = $db->getOne('md_cart');
	
	if($db->count < 1) {
		$id = $db->insert('md_cart', [
			'xauthtoken'	=> $xauthtoken, 
			'storage'		=> $cart,
			'ip'			=> $_SERVER['REMOTE_ADDR']
		]);
	} else {
		$db->where("xauthtoken", $xauthtoken);
		$db->update('md_cart', [
			'xauthtoken'	=> $xauthtoken, 
			'storage'		=> $cart,
			'ip'			=> $_SERVER['REMOTE_ADDR']	
		]);
	}

	die(json_encode([]));
endif;


########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'load_cart'):
	// Пример обработчика корзины, заглушка!
	if( !isset($_COOKIE['xauthtoken']) ) { // Уникальный xauthtoken
		$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));
		
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('xauthtoken', $xauthtoken, time()+60*60*24*365, '/', $domain, false);
	} else {
		$xauthtoken= $db->escape($_COOKIE['xauthtoken']);
	}

	$db->where("xauthtoken", $xauthtoken);
	$md_cart= $db->getOne('md_cart');

	if($db->count > 0) {
		$cart= unserialize($md_cart['storage']);
		die(json_encode( ['cart' => $cart] ));
	}
	

	die(json_encode(['cart'=>'0']));
endif;


?>
