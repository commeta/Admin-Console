<?php



function save_cart($cart){ // Сохранение корзины
	$db = MysqliDb::getInstance();
	$xauthtoken= get_xauthtoken();
	$user_id= login_xauthtoken($xauthtoken, true);
	
	$cart= json_decode($cart, true);
	foreach($cart as &$c) foreach($c as &$p) $p= $db->escape($p);
	
	$cart= serialize($cart);

	$db->where("user_id", $user_id);
	$md_cart= $db->getOne('md_cart');
	
	if($db->count < 1) {
		$id= $db->insert('md_cart', [
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
}



function load_cart(){ // Загрузка корзины
	$db = MysqliDb::getInstance();
	
	$xauthtoken= get_xauthtoken();
	$user_id= login_xauthtoken($xauthtoken);
	if(!$user_id) return 0;
	
	$db->where("user_id", $user_id); 
	$md_cart= $db->getOne('md_cart');

	if($db->count > 0) {
		$cart= unserialize($md_cart['storage']);
		if(is_array($cart) && count($cart) > 0){
			$ids= array_keys($cart); // Доп параметры товара
			$db->where('parent_id', $ids, 'in');
			$md_shop_extended_product= $db->map('parent_id')->ArrayBuilder()->get('md_shop_extended_product', null, ['id','parent_id','cost', 'balance', 'reserved']);
			
			foreach($cart as &$product){ // join
				if( $db->count > 0 && isset($md_shop_extended_product[$product['id']]) ){
					$product= $product + $md_shop_extended_product[$product['id']];
				}
			}
			
			return $cart;
		} 
	}
	
	return 0;
}



function checkout_cart(){
	$db = MysqliDb::getInstance();
	
}



function merge_users_cart($deleted_user_id, $authorized_user_id){ // Объединение пользователей в корзинах, при авторизации в другом браузере, с новым или утеряным токеном
	$db = MysqliDb::getInstance();
	
	$db->where("user_id", $deleted_user_id);
	$deleted_cart= $db->getOne('md_cart', null, ['id', 'event_time', 'storage']);
	if($db->count < 1) return true;
	
	
	$db->where("user_id", $authorized_user_id);
	$authorized_cart= $db->getOne('md_cart', null, ['id', 'event_time', 'storage']);
	
	if($db->count > 0){
		$authorized_cart_storage= unserialize($authorized_cart['storage']);
		$deleted_cart_storage= unserialize($deleted_cart['storage']);
		
		if(is_array($deleted_cart_storage) && count($deleted_cart_storage) > 0){
			if(is_array($authorized_cart_storage) && count($authorized_cart_storage) > 0){
				if($authorized_cart['event_time'] > $deleted_cart['event_time']){
					$db->where("user_id", $deleted_user_id);
					$db->delete('md_cart');
					return true;
				}
			}
			
			$db->where("user_id", $authorized_user_id);
			$db->delete('md_cart');
				
			$db->where("user_id", $deleted_user_id);
			$db->update('md_cart', [
				'user_id' => $authorized_user_id
			]);
		} else {
			$db->where("user_id", $deleted_user_id);
			$db->delete('md_cart');
		}
	} else {
		$db->where("user_id", $deleted_user_id);
		$db->update('md_cart', [
			'user_id' => $authorized_user_id
		]);
	}
	
	return true;
}






?>
