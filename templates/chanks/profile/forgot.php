<main role="main" class="text-center">
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic">Напомнить пароль</h1>
		</div>
	</div>
	
	<div class="container marketing ">
		
		
<?php
if( $submod && $subpage && is_need_change_password($submod, $subpage) ){
?>
		<form class="form-signin needs-validation" method="POST" action="" novalidate id="change_password">
			<div class="text-center mb-4">
				<h2 class="h3 mb-3 font-weight-normal">Введите новый пароль</h2>
				<p>Для смены пароля воспользуйтесь этой формой.</p>
			</div>	
			
			<label for="password" class="sr-only">Новый пароль</label>
			<input type="password" class="form-control" id="password" placeholder="" value="" required pattern=".{5,}">
			<div class="invalid-feedback">
				Введите Ваш пароль. Минимальная длина 5 символов.
			</div>
			
			<label for="password2" class="sr-only">Пароль (еще раз)</label>
			<input type="password" class="form-control" id="password2" placeholder="" value="" required pattern=".{5,}">
			<div class="invalid-feedback">
				Введите подтверждение пароля.
			</div>
			
			<input type="hidden" id="submod" value="<?=$submod?>" >
			<input type="hidden" id="subpage" value="<?=$subpage?>" >
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
		</form>
<?php 
} else { 
?>
		<form class="form-signin needs-validation" method="POST" action="" novalidate id="forgot">
			<div class="text-center mb-4">
				<h2 class="h3 mb-3 font-weight-normal">Напомнить пароль</h2>
				<p>Введите Ваш Email указанный при регистрации.</p>
			</div>	
			<label for="email" class="sr-only">Ваш Email</label>
			<input type="text" class="form-control" id="email" placeholder="Ваш Email" value="" required>
			<div class="invalid-feedback">
				Пожалуйста, введите действительный адрес электронной почты.
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
		</form>
<?php 
} 
?>
		
	</div>

</main>


