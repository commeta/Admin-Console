<?php
// Если есть то отдаем из кэша страницу, и обработаем заголовое if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

require_once('chanks/header.php');
?>
<main role="main" class="chekout">
	<div class="container">
		<div class="py-5 text-center">
			<img class="d-block mx-auto mb-4" src="/img/bootstrap-solid.svg" alt="" width="72" height="72">
			<h2>Форма</h2>
			<p class="lead">Идейные соображения высшего порядка, а также понимание сути ресурсосберегающих технологий однозначно фиксирует необходимость инновационных методов управления процессами.</p>
		</div>

		<div class="row">
			<div class="col-md-4 order-md-2 mb-4 cart-chekout">
				<h4 class="d-flex justify-content-between align-items-center mb-3">
					<span class="text-muted">Ваша корзина</span>
					<span class="badge badge-secondary badge-pill">3</span>
				</h4>
				<ul class="list-group mb-3">
					<li class="list-group-item d-flex justify-content-between lh-condensed">
						<div>
							<h6 class="my-0">Наименование</h6>
							<small class="text-muted">Краткое описание</small>
						</div>
						<span class="text-muted">12</span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed">
						<div>
							<h6 class="my-0">Второй продукт</h6>
							<small class="text-muted">Краткое описание</small>
						</div>
						<span class="text-muted">8</span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed">
						<div>
							<h6 class="my-0">Третий пункт</h6>
							<small class="text-muted">Краткое описание</small>
						</div>
						<span class="text-muted">5</span>
					</li>
					<li class="list-group-item d-flex justify-content-between bg-light">
						<div class="text-success">
							<h6 class="my-0">Промо код</h6>
							<small>Активирован</small>
						</div>
						<span class="text-success">-5</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>Итого (РУБЛИ)</span>
						<strong>20</strong>
					</li>
				</ul>

				<form class="card p-2">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Промо код">
						<div class="input-group-append">
							<button type="submit" class="btn btn-secondary ">Отправить</button>
						</div>
					</div>
				</form>
				
				<div class="p-2"></div>

				<h4 class="d-flex justify-content-between align-items-center mb-3 p-2">
					<span class="text-muted">Сообщение</span>
				</h4>
				<form class="card p-2 needs-validation" novalidate id="send_message">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Имя" id="your-name" required>
						<div class="invalid-feedback">
							Требуется Ваше Имя.
						</div>
					</div>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Email" id="email" required>
						<div class="invalid-feedback">
							Требуется Ваш Email.
						</div>
					</div>
					
					
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Телефон" id="phone">
					</div>
					<div class="input-group">
						<textarea class="form-control" placeholder="Сообщение" id="message" required></textarea>
						<div class="invalid-feedback">
							Введите сообщение.
						</div>
					</div>
					
					<div class="input-group">
						<input type="file" id="files_uploads" class="files_uploads" name="files_uploads" multiple accept=".doc,.docx,.xml,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.bmp,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*">
					</div>
					<div class="preview"></div>
					<div class="input-group p-2">
						<input type="hidden" id="section" value="Тестовое сообщение">
						<button type="submit" class="btn btn-secondary btn-block">Отправить</button>
					</div>
					
				</form>
			</div>
			
			
			
			<div class="col-md-8 order-md-1">
				<h4 class="mb-3">Платежный адрес</h4>
				<form class="needs-validation" novalidate id="checkout">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="firstName">Ваше Имя</label>
							<input type="text" class="form-control" id="firstName" placeholder="" value="" required>
							<div class="invalid-feedback">
								Требуется Ваше Имя.
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="lastName">Ваша Фамилия</label>
							<input type="text" class="form-control" id="lastName" placeholder="" value="" required>
							<div class="invalid-feedback">
								Требуется Ваша Фамилия.
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="username">Логин</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">@</span>
							</div>
							<input type="text" class="form-control" id="username" placeholder="Username" required>
							<div class="invalid-feedback" style="width: 100%;">
								Требуется Ваш логин.
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label for="email">Email <span class="text-muted">(Необязательно)</span></label>
						<input type="email" class="form-control" id="email" placeholder="you@example.com">
						<div class="invalid-feedback">
							Пожалуйста, введите действительный адрес электронной почты для доставки сообщений.
						</div>
					</div>

					<div class="mb-3">
						<label for="address">Адрес</label>
						<input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
						<div class="invalid-feedback">
							Пожалуйста, введите свой адрес доставки.
						</div>
					</div>

					<div class="mb-3">
						<label for="address2">Адрес 2 <span class="text-muted">(Необязательно)</span></label>
						<input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
					</div>

					<div class="row">
						<div class="col-md-5 mb-3">
							<label for="country">Страна</label>
							<select class="custom-select d-block w-100" id="country" required>
								<option value="">Страна...</option>
								<option>Россия</option>
							</select>
							<div class="invalid-feedback">
								Пожалуйста, укажите страну.
							</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="state">Город</label>
							<select class="custom-select d-block w-100" id="state" required>
								<option value="">Выбрать...</option>
								<option>Санкт-Петербург</option>
							</select>
							<div class="invalid-feedback">
								Пожалуйста, укажите город.
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label for="zip">Индекс</label>
							<input type="text" class="form-control" id="zip" placeholder="" required>
							<div class="invalid-feedback">
								Требуется почтовый индекс.
							</div>
						</div>
					</div>
					<hr class="mb-4">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="same-address">
						<label class="custom-control-label" for="same-address">Адрес доставки совпадает с моим платежным адресом</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="save-info">
						<label class="custom-control-label" for="save-info">Сохранить эту информацию для следующего раза</label>
					</div>
					<hr class="mb-4">

					<h4 class="mb-3">Оплата</h4>

					<div class="d-block my-3">
						<div class="custom-control custom-radio">
							<input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
							<label class="custom-control-label" for="credit">Кредитная карта</label>
						</div>
						<div class="custom-control custom-radio">
							<input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
							<label class="custom-control-label" for="debit">Дебетовая карта</label>
						</div>
						<div class="custom-control custom-radio">
							<input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
							<label class="custom-control-label" for="paypal">PayPal</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="cc-name">Имя на карточке</label>
							<input type="text" class="form-control" id="cc-name" placeholder="" required>
							<small class="text-muted">Полное имя как показано на карточке</small>
							<div class="invalid-feedback">
								Имя на карте, обязательно
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="cc-number">Номер кредитной карты</label>
							<input type="text" class="form-control" id="cc-number" placeholder="" required>
							<div class="invalid-feedback">
								Требуется номер кредитной карты
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 mb-3">
							<label for="cc-expiration">Дата истечения</label>
							<input type="text" class="form-control" id="cc-expiration" placeholder="" required>
							<div class="invalid-feedback">
								Требуется Срок годности
							</div>
						</div>
						<div class="col-md-3 mb-3">
							<label for="cc-cvv">CVV код</label>
							<input type="text" class="form-control" id="cc-cvv" placeholder="" required>
							<div class="invalid-feedback">
								Требуется код безопасности
							</div>
						</div>
					</div>
					<hr class="mb-4">
					<input type="hidden" id="cart-chekout-order">
					<button class="btn btn-primary btn-lg btn-block" type="submit">Продолжить оформление заказа</button>
				</form>
			</div>
		</div>
	</div>
</main>

<?php
require_once('chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше
?>
