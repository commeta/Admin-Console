<?php
########################################################################
// Пример обработчика ajax запроса
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



########################################################################
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
