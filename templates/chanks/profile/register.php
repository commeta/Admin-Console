<main role="main" class="register">
	
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic">Регистрация</h1>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4 order-md-2 mb-4 register">
			</div>
			
			
			
			<div class="col-md-8 order-md-1">
				<h4 class="mb-3">Регистрационные данные</h4>
				<form class="needs-validation" novalidate id="register">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="login">Email (Логин)</label>
							<input type="text" class="form-control" id="login" placeholder="" value="" required>
							<div class="invalid-feedback">
								Пожалуйста, введите действительный адрес электронной почты.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="name">Имя</label>
							<input type="text" class="form-control" id="name" placeholder="" value="" required>
							<div class="invalid-feedback">
								Требуется Ваше Имя.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="surname">Фамилия</label>
							<input type="text" class="form-control" id="surname" placeholder="" value="" required>
							<div class="invalid-feedback">
								Требуется Ваша Фамилия.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="patronymic">Отчество</label>
							<input type="text" class="form-control" id="patronymic" placeholder=""  value="" required>
							<div class="invalid-feedback">
								Требуется Ваше Отчество.
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="phone">Пароль</label>
						<div class="input-group">
							<input type="password" class="form-control" id="password" placeholder=""  value="" required pattern=".{5,}">
							<div class="invalid-feedback" style="width: 100%;">
								Введите Ваш пароль. Минимальная длина 5 символов.
							</div>
						</div>
					</div>
					
					<div class="mb-3">
						<label for="phone">Пароль (еще раз)</label>
						<div class="input-group">
							<input type="password" class="form-control" id="password2" placeholder=""  value="" required required pattern=".{5,}">
							<div class="invalid-feedback" style="width: 100%;">
								Введите подтверждение пароля.
							</div>
						</div>
					</div>
					
					<div class="mb-3">
						<label for="phone">Телефон</label>
						<div class="input-group">
							<input type="text" class="form-control" id="phone" placeholder="+7 (xxx) xxx-xx-xx" value="" required>
							<div class="invalid-feedback" style="width: 100%;">
								Требуется Ваш телефонный номер.
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="gender0" name="gender" class="custom-control-input" value="1">
							<label class="custom-control-label" for="gender0">Мужчина</label>
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" id="gender1" name="gender" class="custom-control-input" value="2">
							<label class="custom-control-label" for="gender1">Женщина</label>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5 mb-3">
							<label for="datetimepicker">День рождения</label>
							
							<input id="datetimepicker" type="text">
							<div class="invalid-feedback">
								Пожалуйста, дату дня рождения.
							</div>
						</div>
					</div>
					
					<hr class="mb-4">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="news_check" name="news_check" value="1">
						<label class="custom-control-label" for="news_check">Согласие на получение рассылки</label>
					</div>

					<hr class="mb-4">
					<button class="btn btn-primary btn-lg btn-block" type="submit">Зарегистрировать</button>
				</form>
			</div>
		</div>
	</div>
</main>
