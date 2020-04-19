<!-- Редактирование  -->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box box-content bg-tab">
			<form method="post" action="" class="form-horizontal ajax-form" name="friendly_url" onsubmit="save_url('friendly_url');return false;">
				<fieldset>
					<legend>Параметры URL</legend>
					<div class="form-group">
						<label class="col-sm-2 control-label">URL страницы <a href="#" onclick="insert_url();return false">ψ</a></label>
						<div class="col-sm-10">
							<input type="text" class="form-control counter" name="friendly_url" maxlength=75 /><span>0</span> </div>
					</div>
					<legend>Мета теги</legend>
					<div class="form-group">
						<label class="col-sm-3 control-label">Заголовок h1</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="meta_h1" maxlength=50 /><span>0</span> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">META title</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="meta_title" maxlength=80 /><span>0</span> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">META description</label>
						<div class="col-sm-9">
							<input type="text" class="form-control counter" name="meta_description" maxlength=270 /><span>0</span> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">META keywords</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="meta_keywords" /> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="form-styles">Анонс</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="5" id="meta_text"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="form-styles">Содержание (content)</label>
						<div class="col-sm-12">
							<textarea class="form-control" rows="5" class="editor-container" id="page_content"></textarea>
						</div>
					</div>
				</fieldset>
				<div id="ckfinder1"></div>

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
