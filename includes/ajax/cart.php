<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################


// Работа с корзиной, beta - набросок
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
	foreach($cart as &$c) foreach($c as &$p) $p= $db->escape($p);
	
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
		if(count($cart) > 0){
			$ids= array_keys($cart); // Доп параметры товара
			$db->where('parent_id', $ids, 'in');
			$md_shop_extended_product= $db->map('parent_id')->ArrayBuilder()->get('md_shop_extended_product', null, ['id','parent_id','cost', 'balance', 'reserved']);
			
			foreach($cart as &$product){ // join
				if( $db->count > 0 && isset($md_shop_extended_product[$product['id']]) ){
					$product= $product + $md_shop_extended_product[$product['id']];
				}
			}
			
			die(json_encode( ['cart' => $cart] ));
		} 
	}

	die(json_encode(['cart'=> 0]));
endif;



########################################################################

// Лайки
if(isset($_POST['oper']) && $_POST['oper'] == 'save_like'):
	if( !isset($_COOKIE['xauthtoken']) ) { // Уникальный xauthtoken
		$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));

		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('xauthtoken', $xauthtoken, time()+60*60*24*365, '/', $domain, false);
	} else {
		$xauthtoken= $db->escape($_COOKIE['xauthtoken']);
	}
	
	$tables= [
		'shop'=> 'md_shop_like',
		'portfolio'=> 'md_portfolio_like'
	];
	
	$db->where("xauthtoken", $xauthtoken);
	$db->where("like_id", $db->escape($_POST['like_id']));
	if( array_key_exists($_POST['like_src'], $tables) ) $table= $db->getOne( $tables[$_POST['like_src']] );
	else die(json_encode(['error_table_not_found']));
	
	if($db->count < 1) {
		$id= $db->insert($tables[$_POST['like_src']], [
			'xauthtoken'	=> $xauthtoken, 
			'like_id'		=> $db->escape($_POST['like_id'])
		]);
	} else {
		$db->where("xauthtoken", $xauthtoken);
		$db->where("like_id", $db->escape($_POST['like_id']));
		$db->delete($tables[$_POST['like_src']]);
	}

	$db->where("like_id", $db->escape($_POST['like_id']) );
	$likes = $db->getValue($tables[$_POST['like_src']], "count(*)");

	die(json_encode([ "likes"=>$likes, "like_id"=>$_POST['like_id'] ]));
endif;





if(isset($_POST['oper']) && $_POST['oper'] == 'load_like'):
	$tables= [
		'shop'=> 'md_shop_like',
		'portfolio'=> 'md_portfolio_like'
	];
	
	$likes= [];
	if( array_key_exists($_POST['like_src'], $tables) ){
		foreach(json_decode($db->escape($_POST['ids']), true) as $id){
			$db->where("like_id", $id );
			$likes[$id]= $db->getValue($tables[$_POST['like_src']], "count(*)");
		}
	} else {
		die(json_encode(['error_table_not_found']));
	}

	die(json_encode(['likes'=>$likes]));
endif;



?>
