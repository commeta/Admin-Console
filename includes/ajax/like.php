<?php
########################################################################
// Пример обработчика ajax запроса
########################################################################

// Лайки
if(isset($_POST['oper']) && $_POST['oper'] == 'save_like'):
	if( isset($_POST['like_src']) && isset($_POST['like_id']) ){
		$likes = save_like($_POST['like_src'], $_POST['like_id']);
		die(json_encode([ "likes"=>$likes, "like_id"=>$_POST['like_id'] ]));
	} else {
		die(json_encode([]));
	}
endif;



########################################################################
if(isset($_POST['oper']) && $_POST['oper'] == 'load_like'):
	$likes= [];

	if( isset($_POST['like_src']) && isset($_POST['ids']) ){
		$likes= load_like($_POST['like_src'], $_POST['ids']);
	}
	
	die(json_encode(['likes'=>$likes]));
endif;



?>
