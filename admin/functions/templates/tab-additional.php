<!-- Редактирование  -->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box box-content bg-tab">
			<form method="post" action="" class="form-horizontal ajax-form" name="additional_fields" onsubmit="save_url('additional_fields');return false;">
				<div class="box">
					<div class="box-header">
						<div class="box-name"> <i class="fa fa-picture-o"></i> <span>Буфер обмена изображениями:</span> </div>
						<div class="no-move"></div>
					</div>
					<div id="images_collection_additional" class="box-content"></div>
				</div>
				<div id="ckfinder1"></div>
				<?php print_additional_fields();?>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary"> Сохранить <i class="fa fa-refresh fa-spin"></i> </button>
						</div>
					</div>
			</form>
		</div>
	</div>
</div>
<!-- /Редактирование  -->
