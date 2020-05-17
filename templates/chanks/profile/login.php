<main role="main" class="text-center">
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic"><?=$meta_h1?></h1>
		</div>
	</div>
	
	<div class="container marketing ">
		<form class="form-signin" method="POST" action="">
			<div class="text-center mb-4">
				<h2 class="h3 mb-3 font-weight-normal">Войти</h2>
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
			
			
			<label for="inputEmail" class="sr-only">Ваш Email</label>
			<input type="email" id="inputEmail" name="login" class="form-control" placeholder="Ваш Email" required autofocus>
			<label for="inputPassword" class="sr-only">Пароль</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Пароль" required>
			<div class="checkbox mb-3">
				<a href="/profile/forgot.html">Напомнить пароль</a> | <a href="/profile/register.html">Регистрация</a>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
		</form>
	</div>
</main>

