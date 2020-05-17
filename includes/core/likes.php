<?php

function load_like($like_src, $ids){ // Возвращает массив количество лайков по списку id
	$db = MysqliDb::getInstance();
	$likes= [];

	$like_src= $db->escape($like_src);
	$ids= $db->escape($ids);
	$ids= json_decode($ids, true);
	
	if( is_array($ids) ){
		foreach($ids as $id){
			$db->where("template", $like_src );
			$db->where("like_id", $db->escape($id) );
			$likes[$id]= $db->getValue('md_likes', "count(*)");
		}
	}
	
	return $likes;
}


function save_like($like_src, $like_id){ // Сохраняет лайк в базе, возвращает количество лайков
	$db = MysqliDb::getInstance();

	$xauthtoken= get_xauthtoken();
	$user_id= login_xauthtoken($xauthtoken, true);
	
	$like_src= $db->escape($_POST['like_src']);
	$like_id= (int)$db->escape($_POST['like_id']);
		
	$db->where("template", $like_src );
	$db->where("user_id", $user_id);
	$db->where("like_id", $like_id);
	
	$table= $db->getOne('md_likes');
	
	if($db->count < 1) {
		$id= $db->insert('md_likes', [
			'user_id'	=> $user_id, 
			'like_id'	=> $like_id,
			'template'	=> $like_src
		]);
	} else {
		$db->where("template", $like_src );
		$db->where("user_id", $user_id);
		$db->where("like_id", $like_id);
		$db->delete('md_likes');
	}

	$db->where("template", $like_src );
	$db->where("like_id", $like_id );
	$likes = $db->getValue('md_likes', "count(*)");

	return $likes;	
}


function merge_users_like($deleted_user_id, $authorized_user_id){ // Объединение пользователей в лайках, при авторизации в другом браузере, с новым или утеряным токеном
	$db = MysqliDb::getInstance();

	$db->where("user_id", $deleted_user_id);
	$deleted_likes= $db->get('md_likes', null, ['id', 'like_id', 'template']);
	if($db->count < 1) return true;
	
	
	$db->where("user_id", $authorized_user_id);
	$authorized_likes= $db->get('md_likes', null, ['id', 'like_id', 'template']);
	
	if($db->count > 0){
		$delete_ids= [];
		$update_ids= [];
		
		foreach($deleted_likes as $dl){		
			$al= array_filter($authorized_likes, fn($v) => $v['like_id'] == $dl['like_id'] && $v['template'] == $dl['template']);
			
			if( is_array($al) && count($al) > 0 ){
				$delete_ids[]= $dl['id'];
			} else {
				$update_ids[]= $dl['id'];
			}
		}
		
		if( count($delete_ids) > 0 ){
			$db->where('id', $delete_ids, 'in');
			$db->delete('md_likes');
		}
		
		if( count($update_ids) > 0 ){
			$db->where('id', $update_ids, 'in');
			$db->update('md_likes', [
				'user_id' => $authorized_user_id
			]);
		}

	} else {
		$db->where("user_id", $deleted_user_id);
		$db->update('md_likes', [
			'user_id' => $authorized_user_id
		]);
	}
	
	return true;
}


?>
