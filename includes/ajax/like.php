<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################

// Лайки
if(isset($_POST['oper']) && $_POST['oper'] == 'save_like'):
	$xauthtoken= get_xauthtoken();
	$user_id= login_xauthtoken($xauthtoken, true);
		
	$db->where("template", $db->escape($_POST['like_src']) );
	$db->where("user_id", $user_id);
	$db->where("like_id", $db->escape($_POST['like_id']));
	
	$table= $db->getOne('md_likes');
	
	if($db->count < 1) {
		$id= $db->insert('md_likes', [
			'user_id'	=> $user_id, 
			'like_id'	=> $db->escape($_POST['like_id']),
			'template'	=> $db->escape($_POST['like_src'])
		]);
	} else {
		$db->where("template", $db->escape($_POST['like_src']) );
		$db->where("user_id", $user_id);
		$db->where("like_id", $db->escape($_POST['like_id']));
		$db->delete('md_likes');
	}

	$db->where("template", $db->escape($_POST['like_src']) );
	$db->where("like_id", $db->escape($_POST['like_id']) );
	$likes = $db->getValue('md_likes', "count(*)");

	die(json_encode([ "likes"=>$likes, "like_id"=>$_POST['like_id'] ]));
endif;



########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'load_like'):
	$likes= [];

	foreach(json_decode($db->escape($_POST['ids']), true) as $id){
		$db->where("template", $db->escape($_POST['like_src']) );
		$db->where("like_id", $db->escape($id) );
		$likes[$id]= $db->getValue('md_likes', "count(*)");
	}

	die(json_encode(['likes'=>$likes]));
endif;



?>
