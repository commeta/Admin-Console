<!-- Редактирование  -->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box box-content bg-tab">
			<form method="post" action="" class="form-horizontal ajax-form" name="additional_fields" onsubmit="save_url('additional_fields');return false;">
				<div id="additional_fields" class="sort"></div>
				
				<div class="form-group">
					<div class="col-sm-9 col-sm-offset-3">
						<button type="submit" class="btn btn-primary"> Сохранить <i class="fa fa-refresh fa-spin"></i> </button>
						<button class="btn btn-info" onclick="create_additional_fields('slider');return false;"> Добавить в слайдер </button>
						<button class="btn btn-info" onclick="create_additional_fields('gallery');return false;"> Добавить в галерею </button>
						<button class="btn btn-info" onclick="create_additional_fields('info');return false;"> Добавить в инфоблок </button>
					</div>
				</div>
				<p>Вставка из буфера обмена (правая панель), сортировка перемещением.</p>
			</form>
		</div>
	</div>
</div>
<!-- /Редактирование  -->
