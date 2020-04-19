<?php
const db_table= 'md_meta';
const db_table_images= 'md_meta_img';

const root_path_url= '/';
require_once('includes.php');
#######################################################################

?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-link"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Управление сайтом</a></li>
			<li><a href="#">Главные разделы</a></li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box box-content bg-tab">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1"><i class="fa fa-link"></i> Главные разделы</a></li>
					<li><a href="#tabs-2"><i class="fa fa-edit"></i> Редактор страницы</a></li>
					<li><a href="#tabs-3"><i class="fa fa-edit"></i> Дополнительные поля</a></li>
				</ul>
				<div id="tabs-1">
<?php require_once('templates/tab-table.php');?>
				</div>
				<div id="tabs-2">
<?php require_once('templates/tab-editor.php');?>
				</div>
				<div id="tabs-3">
<?php require_once('templates/tab-additional.php');?>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
//this_path= window.location.href.split('#').join('');
this_path= '/admin/functions/friendly.php';
root_path_url= "<?php echo root_path_url;?>";

$(document).ready(function() {
	$("#tabs").tabs({disabled:[1,2]}); // Create jQuery-UI tabs
	
	LoadSelect2_4Script(Select2_4);
	LoadDataTablesScripts(AllTables);
	//LoadBootstrapValidatorScript(mainFormValidator);
});
</script>
