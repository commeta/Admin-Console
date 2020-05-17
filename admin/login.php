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
$db= MysqliDb::getInstance();
$xauthtoken= get_xauthtoken();
$_SESSION['xauthtoken']= $xauthtoken;


if( isset($_POST['login']) ) $login_bruteforce_check= login_bruteforce_check();
else $login_bruteforce_check= 5;

if( isset($_POST['password']) &&
	isset($_POST['login']) &&
	$_POST['login'] != '' &&
	$_POST['password'] != '' &&
	$login_bruteforce_check > 0 &&
	$md_users= login_password($_POST['login'], $_POST['password'])
){
	if($md_users['role'] == 1){
		$_SESSION['auth']= 'authorized';
		$_SESSION['md_users']= $md_users;
		
		$db->where("login_ip", $db->escape($_SERVER['REMOTE_ADDR'])); // Сброс попыток ввода пароля
		$db->delete('md_users_security');
			
		header ("location: /admin/");
		exit;
	}
} else {
	$_SESSION['auth']= 'anonymous';
	if(isset($_SESSION['md_users'])) unset($_SESSION['user']);
}

#######################################################################



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
							<input type="text" class="form-control" name="login" />
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
	if($login_bruteforce_check < 5){
		if($login_bruteforce_check < 1) {
			printf("<p>Вы исчерпали попытки ввода пароля!<br />Повтор возможен через: %s</p>", get_login_block_time() );
		}
		else {
			$arWords = array('попытка','попытки','попыток');
			$answer= declension_words($login_bruteforce_check, $arWords);
			echo "<p>Неверный логин или пароль!<br />Осталось: <code>$login_bruteforce_check</code> $answer</p>";
		}
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
