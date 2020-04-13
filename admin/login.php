<?php
session_start();
require_once('../includes/config.inc.php');

// Подключение библиотеки функций ядра
foreach (glob("../includes/core/*.php") as $filename){
    include $filename;
} 

// Подключение библиотеки функций ядра админки
foreach (glob("core/*.php") as $filename){
    include $filename;
} 

########################################################################
$db = MysqliDb::getInstance();

#######################################################################

if(isset($_POST['username']) && isset($_POST['password'])) {
	$count= bruteforceCheck();
}

#######################################################################

if(isset($_POST['username']) && isset($_POST['password']) && $count > 0){
	$db->where('login_datetime < (NOW() - INTERVAL 1 DAY)');
	$db->delete('md_users_login');
	
	$username = $db->escape($_POST['username']);
	$password = md5($db->escape($_POST['password']));
		
	$db->where('login',$username);
	$db->where('password', $password );
	$user_id = $db->getOne('md_users','user_id');

	if($db->count > 0){
		$xauthtoken= strval(bin2hex(openssl_random_pseudo_bytes(32)));
		
		$data = Array (
			"user_id"		=> array_shift($user_id),
			"xauthtoken"	=> $xauthtoken,
			"login_ip"		=> $_SERVER['REMOTE_ADDR']
		);
		$user_login_id= $db->insert('md_users_login', $data);	
		
		if(isset($user_login_id)){
			$_SESSION['xauthtoken'] = $xauthtoken;
			header ("location: /admin/");
			exit;
		}
	}
}

if(isset($_SESSION['xauthtoken'])){
	$xauthtoken = $db->escape($_SESSION['xauthtoken']);

	$db->where('xauthtoken', $xauthtoken );
	$user_id = $db->getOne('md_users_login','user_login_id');
	if($db->count > 0){
		header ("location: /admin/");
		exit;
	}
}




#######################################################################
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin Console</title>
		<meta name="description" content="description">
		<meta name="author" content="Evgeniya">
		<meta name="keyword" content="keywords">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="css/style_v2.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
<div class="container-fluid">
	<div id="page-login" class="row">
		<div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<!--
			<div class="text-right">
				<a href="page_register.html" class="txt-default">Need an account?</a>
			</div>
			-->
			
			<div class="box">
				<div class="box-content">
					<form method="post" action="login.php">
						<div class="text-center">
							<h3 class="page-header">Admin Console Авторизация</h3>
						</div>
						<div class="form-group">
							<label class="control-label">Имя пользователя</label>
							<input type="text" class="form-control" name="username" />
						</div>
						<div class="form-group">
							<label class="control-label">Пароль</label>
							<input type="password" class="form-control" name="password" />
						</div>
						<div class="text-center">
							<button class="btn btn-primary" type="submit">Войти</button>
						</div>
						
						<div class="text-center">
<?php
if(isset($count)){
	if($count < 5) echo "Неверный логин или пароль!<br />Осталось попыток ввода: ",$count,"<br />";
	if($count == 0)  echo "Вы исчерпали количество ошибок ввода!<br /> Cможете повторить не ранее чем через минуту.";
}
?>
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
