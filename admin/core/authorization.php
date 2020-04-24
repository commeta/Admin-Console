<?php


#######################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */
function xauthtokenCheck($xauthtoken){
	$db = MysqliDb::getInstance();
	$xauthtoken = $db->escape($xauthtoken);

	$db->where('xauthtoken', $xauthtoken );
	$user_id = $db->getOne('md_users_login','user_id');
	if(!isset($user_id)){
		header ("location: /admin/login.php");
		exit;
	}
	
	return(array_shift($user_id));
}


#######################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function bruteforceCheck(){
	if( file_exists(root_path."admin/bruteforce.check") ){
		$bruteforceCheck= unserialize(file_get_contents(root_path."admin/bruteforce.check"));
		
		foreach($bruteforceCheck as $k=>$v){
			if(intval($v['TIMESTAMP']) + 3600 < time() ){
				unset($bruteforceCheck[$k]);
			}
		}
		
		if(array_key_exists($_SERVER['REMOTE_ADDR'],$bruteforceCheck)){
			if(intval($bruteforceCheck[$_SERVER['REMOTE_ADDR']]['COUNT']) > 0){
				$bruteforceCheck[$_SERVER['REMOTE_ADDR']]['COUNT']--;
			}
			if(intval($bruteforceCheck[$_SERVER['REMOTE_ADDR']]['COUNT']) == 0){
				if( intval($bruteforceCheck[$_SERVER['REMOTE_ADDR']]['TIMESTAMP']) + 60 < time() ){
					$bruteforceCheck[$_SERVER['REMOTE_ADDR']]['COUNT'] = 2;
				}
			}
			$bruteforceCheck[$_SERVER['REMOTE_ADDR']]['TIMESTAMP']= time();
			
		} else {
			$bruteforceCheck[$_SERVER['REMOTE_ADDR']] = array(
				'COUNT'	=> 5,
				'TIMESTAMP'	=> time()
			);
		}
	} else {
		$bruteforceCheck= array(
			$_SERVER['REMOTE_ADDR'] => array(
				'COUNT'	=> 5,
				'TIMESTAMP'	=> time()
			)
		);
	}
		
	file_put_contents(root_path."admin/bruteforce.check",serialize($bruteforceCheck));
	return( $bruteforceCheck[$_SERVER['REMOTE_ADDR']]['COUNT'] );
}
?>
