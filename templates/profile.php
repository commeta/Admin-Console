<?php

$db->where('friendly_url', '/profile/' );
$md_meta= $db->getOne('md_meta');
if($db->count < 1) goto die404;
	
$meta_title			= $md_meta['meta_title'];
$meta_h1			= $md_meta['meta_h1'];
$meta_description	= $md_meta['meta_description'];
$meta_keywords		= $md_meta['meta_keywords'];
$canonical			= siteUrl."/profile/";
$robots				= "noindex, nofollow";


if( isset($_POST['logout']) && $_POST['logout'] == 'logout') {
	logout_user();
}




if( login_check() ){ // Для залогиненных
	$db->where("login_ip", $db->escape($_SERVER['REMOTE_ADDR'])); // Сброс попыток ввода пароля
	$db->delete('md_users_security');
	
	if( $request_url['path'] == '/profile/' ||
		$page == "orders" ||
		$page == "services" ||
		$page == "settings" ||
		$page == "reports" ||
		$page == "documents"
	) {	
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/profile/profile.php');
		require_once('chanks/footer.php');
		exit;
	} else {
		if( $page == "confirm"){
			require_once(pages_dir.'chanks/header.php');
			require_once(pages_dir.'chanks/profile/confirm.php');
			require_once('chanks/footer.php');
			exit;
		}
	}
	
	goto die404;
}






if($request_url['path'] == '/profile/') { // Если это раздел
	if( isset($_POST['login']) ) $login_bruteforce_check= login_bruteforce_check();
	else $login_bruteforce_check= 5;

	if( isset($_POST['password']) &&
		isset($_POST['login']) &&
		$_POST['login'] != '' &&
		$_POST['password'] != '' &&
		$login_bruteforce_check > 0 &&
		$md_users= login_password($_POST['login'], $_POST['password'])
	){
		$_SESSION['auth']= 'authorized';
		$_SESSION['md_users']= $md_users;
		
		header ("location: /profile/");
		exit;
	} else {
		$_SESSION['auth']= 'anonymous';
		if(isset($_SESSION['md_users'])) unset($_SESSION['user']);
		
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/profile/login.php');
	}

	require_once('chanks/footer.php');
	exit;
} else {
	
	if( $page == "forgot" ){
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/profile/forgot.php');
		require_once('chanks/footer.php');
		exit;
	}
	

	if($request_url['path'] == '/profile/register.html'){
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/profile/register.php');
		require_once('chanks/footer.php');
		exit;
	}
	
	if( $page == "confirm"){
		require_once(pages_dir.'chanks/header.php');
		require_once(pages_dir.'chanks/profile/confirm.php');
		require_once('chanks/footer.php');
		exit;
	}
	
}
	
die404:
	header("HTTP/1.0 404 Not Found");
	require_once(pages_dir."404.php");
	exit;
?>
