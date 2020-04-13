<?php
require_once('includes.php');

#######################################################################


if( isset($_GET['save_profile']) && isset($_POST['ajax']) ){	// Менеджер обработки ajax запросов


	
	die(json_encode(array('status'=>'Никаких действий не выполнено!' )));
}




?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Профиль</a></li>
			<li><a href="#">Администратор</a></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box box-content bg-tab">
			<form method="post" action="" class="form-horizontal ajax-form" name="profile" onsubmit="save_url('profile');return false;">
				<fieldset>
					<legend>Параметры профиля</legend>
					<div class="form-group">
						<label class="col-sm-3 control-label">Логин</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="login" /> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Имя пользователя</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="name" /> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="phone" /> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Пароль</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="password" /> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Пароль еще раз</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="pass" /> </div>
					</div>
				</fieldset>

				<div class="form-group">
					<div class="col-sm-9 col-sm-offset-3">
						<button type="submit" class="btn btn-primary"> Сохранить <i class="fa fa-refresh fa-spin"></i> </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
