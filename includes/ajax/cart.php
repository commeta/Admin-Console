<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################


// Работа с корзиной, beta - набросок
########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'save_cart'):
	// Пример обработчика корзины, заглушка!
	$xauthtoken= get_xauthtoken();

	$cart= json_decode($_POST['cart'], true);
	foreach($cart as &$c) foreach($c as &$p) $p= $db->escape($p);
	
	$cart= serialize($cart);
	$user_id= login_xauthtoken($xauthtoken, true);

	$db->where("user_id", $user_id);
	$md_cart = $db->getOne('md_cart');
	
	if($db->count < 1) {
		$id = $db->insert('md_cart', [
			'user_id'		=> $user_id, 
			'storage'		=> $cart
		]);
	} else {
		$db->where("user_id", $user_id);
		$db->update('md_cart', [
			'user_id'		=> $user_id, 
			'storage'		=> $cart
		]);
	}

	die(json_encode([]));
endif;


########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'load_cart'):
	// Пример обработчика корзины
	$xauthtoken= get_xauthtoken();
	$user_id= login_xauthtoken($xauthtoken);
	if(!$user_id) die(json_encode(['cart'=> 0]));
	
	$db->where("user_id", $user_id); 
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
if(isset($_POST['oper']) && $_POST['oper'] == 'checkout'):
	// Пример обработчика корзины, заглушка!
	session_start(); // Работа с сессиями
	if( !isset($_SESSION['xauthtoken']) ) { // Уникальный xauthtoken
		$_SESSION['xauthtoken']= get_xauthtoken();

	}
	

	die(json_encode($_POST));
endif;


?>
