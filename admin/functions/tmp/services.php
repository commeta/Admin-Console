<?php
/*
CREATE TABLE IF NOT EXISTS `md_services` (
  `meta_id` int(11) NOT NULL,
  `friendly_url` varchar(256) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_h1` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_text` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `md_services`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `friendly_url` (`friendly_url`);


ALTER TABLE `md_services`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;
*/  

require_once('includes.php');
//$citys= getCity();

if(isset($_GET['get_table'])){	// Менеджер обработки ajax запросов от таблиц
	if($_GET['get_table'] == 'ajax'){ // Загрузка Таблицы
		// DB table to use
		$table = 'md_services';
		 
		// Table's primary key
		$primaryKey = 'meta_id';		
				
		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database, while the `dt` parameter represents the DataTables column identifier. In this case simple indexes
		$columns = array(
			array( 'db' => 'meta_id', 'dt' => 0 ),
			array( 'db' => 'friendly_url',  'dt' => 1 ),
			array( 'db' => 'meta_title',  'dt' => 2 ),
			array(
				'db'        => 'meta_id',
				'dt'        => 3,
				'formatter' => function( $d, $row ) {
					return
						sprintf(' <center><a href="%s" class="ajax-link open_page" target="_BLANC" title="Открыть страницу" ><i class="fa fa-link" ></i></a> |',$row['friendly_url']).
						sprintf(' <a href="javascript:void()" class="ajax-link friendly_url" meta_id="%s" title="Редактировать URL" ><i class="fa fa-edit" ></i></a> |',$d).
						sprintf(' <a href="javascript:void()" class="ajax-link del_url" meta_id="%s" title="Удалить URL"><i class="fa fa-times" ></i></a></center> ',$d);
				}
			)
		);	
		
		$result= SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
		die(json_encode($result) );
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!' )));
}



if(isset($_POST['ajax'])){	// Менеджер обработки ajax запросов
	header('Content-type: application/json');


	if(isset($_POST['oper'])){ // Операции
		if($_POST['oper'] == 'add_url'){ // Добавление url
			$id = $db->insert ('md_services', array('friendly_url'=>"new_url_".time(), 'meta_title'=>"Новый URL ".date("d.m.y H:i:s") ));
			$_POST['id']= $id;
			
			if($id) {
				$_POST['oper']= 'load_url';
				$_POST['id']= $id;
				$status= 'Добавление и загрузка url в редактор';
			} else {
				die(json_encode(array('status'=>'Название url не добавлено.','css_class'=>'danger')));
			}
		}

		if($_POST['oper'] == 'load_url'){ // Загрузка значения
			$id = $db->escape($_POST['id']);
			
			$db->where('meta_id', $id );
			$friendly_url = $db->getOne('md_services');
						
			if($db->count > 0) die(json_encode(array(
				'status'=> isset($status) ? $status : 'url загружен.',
				'css_class'=> 'success',
				'friendly_url'=> $friendly_url['friendly_url'],
				
				'meta_h1'=> $friendly_url['meta_h1'],
				'meta_title'=> $friendly_url['meta_title'],
				'meta_description'=> $friendly_url['meta_description'],
				'meta_keywords'=> $friendly_url['meta_keywords'],
				'meta_text'=> $friendly_url['meta_text'],
				'content'=> $friendly_url['content'],
				'image'=> $friendly_url['image'],
				'meta_id'=> $friendly_url['meta_id']
			)));
			die(json_encode(array('status'=>'URL не загружено.','css_class'=>'danger','name'=> '' )));
		}
		
		if($_POST['oper'] == 'save_url'){ // Редактирование, сохранение результата
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'Страница сохранена.','css_class'=>'danger')));

			$id = $db->escape($_POST['id']);
			$db->where('meta_id', $id ); // Сохраним
			
			if($db->update('md_services', array(
				'friendly_url'=>$db->escape($_POST['friendly_url']),
				'meta_h1'=>$db->escape($_POST['meta_h1']),
				'meta_title'=>$db->escape($_POST['meta_title']),
				'meta_description'=>$db->escape($_POST['meta_description']),
				'meta_keywords'=>$db->escape($_POST['meta_keywords']),
				'meta_text'=>$db->escape($_POST['meta_text']),
				'content'=>$db->escape(str_replace(["\r\n","\n"],'',$_POST['content'])),
				'image'=>$db->escape($_POST['image'])
			))){
				die(json_encode(array('status'=>'Страница сохранена.','css_class'=>'success')));
			}
			
			die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
		}
		
		if($_POST['oper'] == 'get_table'){ // Получить таблицу импорта
			//$md_clinics= $db->get("md_clinics", null, ['clinic_id','name']);
			$md_services= $db->get("md_services", null, ['meta_id','meta_h1']);
			
			die(json_encode(array('status'=>'Таблица получена.','css_class'=>'success', 'import'=>$md_services)));
		}
		
		if($_POST['oper'] == 'del_url'){ // Удалить
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
			
			$id = $db->escape($_POST['id']);
			$db->where('meta_id', $id);
			if($db->delete('md_services')) die(json_encode(array('status'=>'URL удален.','css_class'=>'success' )));
			
			die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
		}
		
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!','css_class'=>'danger')));
}


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
					</ul>
					<div id="tabs-1">
						<!-- Таблица города -->				
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<div class="box-name">
											<i class="fa fa-link"></i>
											<span>URL:</span>
										</div>
										<div class="box-icons">
											<a class="collapse-link">
												<i class="fa fa-chevron-up"></i>
											</a>
											<a class="expand-link">
												<i class="fa fa-expand"></i>
											</a>
											<a class="close-link">
												<i class="fa fa-times"></i>
											</a>
										</div>
										<div class="no-move"></div>
									</div>
									<div class="box-content no-padding table-responsive bg-tab">
										<table class="table beauty-table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-main">
											<thead>
												<tr>
													<th style="white-space:nowrap; width:30px;">ID</th>
													<th>URL</th>
													<th>Title</th>
													<th style="white-space:nowrap; width:130px;">Действия</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>URL</th>
													<th>Title</th>
													<th>Действия</th>
												</tr>
											</tfoot>
										</table>
										<ul class="list-inline text-center">
											<li><button class="btn btn-default add-url"><i class="fa fa-plus"></i> Добавить URL</button></li>
										</ul>									
									</div>
								</div>
							</div>
						</div>
						<!-- /Таблица  -->				
					</div>
					<div id="tabs-2">
						<!-- Редактирование  -->				
						<div class="row">
							<div class="col-xs-12 col-sm-12">
									<div class="box box-content bg-tab">
										
										
										
										<form method="post" action="" class="form-horizontal ajax-form" name="friendly_url">
											<fieldset>
												<legend>Параметры URL</legend>
												<div class="form-group">
													<label class="col-sm-2 control-label">URL страницы</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" name="friendly_url" />
													</div>
												</div>
												
												
													
													
												<legend>Мета теги</legend>	
													<div class="form-group">
														<label class="col-sm-3 control-label">Заголовок h1</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" name="meta_h1" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">META title</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" name="meta_title" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">META description</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" name="meta_description" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">META keywords</label>
														<div class="col-sm-9">
															<input type="text" class="form-control" name="meta_keywords" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="form-styles">Описание (description)</label>
														<div class="col-sm-10">
																<textarea class="form-control" rows="5" id="meta_text"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 control-label" for="form-styles">Содержание (content)</label>
														<div class="col-sm-12">
																<textarea class="form-control" rows="5" class="editor" id="editor"></textarea>
														</div>
													</div>
											</fieldset>
											


											
												<div class="box">
													<div class="box-header">
														<div class="box-name">
															<i class="fa fa-picture-o"></i>
															<span>Изображения:</span>
														</div>
														<div class="no-move"></div>
													</div>
													<div id="images_collection" class="box-content"></div>
												</div>
												<div id="ckfinder1"></div>
											
											
											
											
											
											<div class="form-group">
												<div class="col-sm-9 col-sm-offset-3">
													<button type="submit" class="btn btn-primary">
														Сохранить
														<i class="fa fa-refresh fa-spin"></i>
													</button>
												</div>
											</div>
										</form>
									</div>
							</div>
						</div>
						<!-- /Редактирование  -->				
					</div>
				</div>
			</div>
	</div>
</div>


<script src="/admin/plugins/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
var st_func= true;
$('#datatable-main').on( 'draw.dt', function () { // При обновлении таблицы
	// Обработчик
	//$('#datatable-main').on('click', 'a', function (e) {
		//e.preventDefault();
		//event.stopPropagation();
		
		//if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
		//st_func= false;
		
		
		//if($(this).hasClass('friendly_url')){ // Клик из таблицы, редактирование
		$('#datatable-main .friendly_url').click(function(e){
			e.preventDefault();
			event.stopPropagation();
			
			$('form[name="friendly_url"]').attr( 'meta_id', $(this).attr('meta_id') );
			
			var form_data= new FormData();
			form_data.append("oper", 'load_url');
			form_data.append("id", $(this).attr('meta_id'));

			saveAndLoadAjaxContent(form_data, function(data){ // Загрузим значение в поле, и переключим на вкладку редактора
				setUpEditor(data);
				st_func= true;
			});
			return false;
		});
		
		//if($(this).hasClass('del_url')){ // Клик из таблицы, удаление
		$('#datatable-main .del_url').click(function(){
			var form_data= new FormData();
			form_data.append("oper", 'del_url');
			form_data.append("id", $(this).attr('meta_id'));

			$('form[name="friendly_url"]').attr('meta_id',"undefined");
			
			saveAndLoadAjaxContent(form_data, function(data){ // Удаляем 
				logger(data.status, data.css_class);
				
				var table = $('#datatable-main').DataTable(); // Обновить таблицу
				table.draw(); 
				st_func= true;
			});
			return false;
		});
		
		return false;
	//});
});



function setUpEditor(data){ // Загрузка в  редактор полей из базы
	$("#tabs").tabs('enable',1);
	$('#tabs').tabs("option", "active", 1);
	
	$('form[name="friendly_url"] input[name="friendly_url"]').val( data.friendly_url );
	
		
	
	$('form[name="friendly_url"] input[name="meta_h1"]').val( data.meta_h1 );
	$('form[name="friendly_url"] input[name="meta_title"]').val( data.meta_title );
	$('form[name="friendly_url"] input[name="meta_description"]').val( data.meta_description );
	$('form[name="friendly_url"] input[name="meta_keywords"]').val( data.meta_keywords );
	$('form[name="friendly_url"] #meta_text').val( data.meta_text );
	$('form[name="friendly_url"] #editor').val( data.content );
	
	$('#images_collection').html('');
	if(data.image != '' && data.image != 'undefined') $('#images_collection').append('<a class="fancybox" rel="gallery1" href="' + data.image + '" title=""><img src="' + data.image + '" width="250px" alt=""></a>');
	
	
	CKFinder.widget( 'ckfinder1', { // Загрузим фотки филиала в редактор изображений ckfinder
		height: 600,
		chooseFiles: true,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) {
				var file = evt.data.files.first();
				$('#images_collection').html('');
				$('#images_collection').append('<a class="fancybox" rel="gallery1" href="' + file.getUrl() + '" title=""><img src="' + file.getUrl() + '" width="250px" alt=""></a>');
			});
			finder.on( 'file:choose:resizedImage', function( evt ) {
				//document.getElementById( 'url' ).value = evt.data.resizedUrl;
				console.log( evt.data.resizedUrl );
			});
		}
	});

/*
	tinymce.init({
		height: 500,
		selector: '#editor',  // change this value according to your HTML
		language: 'ru'
	});
*/

	logger(data.status, data.css_class);
	
}

$('.add-url').click(function(){ // Добавить url
	if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
	st_func= false;

	var form_data= new FormData();
	form_data.append("oper", 'add_url');
			
	saveAndLoadAjaxContent(form_data, function(data){ // Загрузим значение в поле, и переключим на вкладку редактора
		$('form[name="friendly_url"]').attr( 'meta_id', data.meta_id );
		setUpEditor(data);
		
		var table = $('#datatable-main').DataTable(); // Обновить таблицу
		table.draw();
		
		logger(data.status, data.css_class);
		st_func= true;
	});
});



function create_url(){ // Создает URL для фильтра
	return;
}

function get_count(){
	var form_data= new FormData();
	form_data.append("oper", 'get_count');
	form_data.append("url", "/clinics?" + create_url() );
	saveAndLoadAjaxContent(form_data, function(data){
		//console.log( data );
		$('input[name="count"]').val( data.count );
	});
}

$('.ajax-form').submit(function(e){ // Перехват отправки форм
	$(this).find('.btn').addClass("btn-danger");
	
	var oper_name=  $(this).attr('name');
	
	if(oper_name == 'friendly_url'){ // Сохранение из формы редактирование
		var form_data= new FormData();
		form_data.append("oper", 'save_url');
		form_data.append("id", $(this).attr('meta_id'));
		form_data.append("friendly_url", $('input[name="friendly_url"]').val() );
		
		form_data.append("url", "/clinics?" + create_url() );
		form_data.append("check_url", "clinics" + create_url() );
		
		form_data.append("meta_h1", $('input[name="meta_h1"]').val() );
		form_data.append("meta_title", $('input[name="meta_title"]').val() );
		form_data.append("meta_description", $('input[name="meta_description"]').val() );
		form_data.append("meta_keywords", $('input[name="meta_keywords"]').val() );
		form_data.append("meta_text", $('#meta_text').val() );
		form_data.append("content", tinymce.activeEditor.getContent() );
		form_data.append("image", $('#images_collection img').attr('src') );
		
		
		
		saveAndLoadAjaxContent(form_data, function(data){
			logger(data.status, data.css_class);
			$('form[name="'+oper_name+'"]').find('.btn').removeClass("btn-danger");
			$('form[name="'+oper_name+'"]').find('.btn').prop('disabled',false);

			var table = $('#datatable-main').DataTable(); // Обновить таблицу
			table.draw(); 
		});
	}
	
	return false;
});





function saveAndLoadAjaxContent(form_data= new FormData(), succesCallback= false){
	if (typeof (succesCallback) !== "function") throw new Error('succesCallback must be a function !');
	
	form_data.append("ajax", true);

	$.ajax({
		url: '/admin/functions/services.php',
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: "post",
		success: succesCallback,
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		async: true
	});
}


// Create jQuery-UI tabs
$("#tabs").tabs({disabled:[1]});

// Run Select2 plugin on elements
function Select2_4(){
	$('.multiple_select').select2({
		placeholder: "Выбор",
		allowClear: true,						
		tags: true,
		tokenSeparators: [',', ' '],
		width: '100%'
		//data: data.clinic_specialism
	});
	
	$('form[name="friendly_url"] select').select2({width: '100%'});
}
 		
// Run Datables plugin and create of settings
function AllTables(){
	$('#datatable-main').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "/admin/functions/services.php?get_table=ajax",
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sSearch": "Поиск по базе: ",
			"sLengthMenu": '_MENU_'
		}
	});
	}

$(document).ready(function() {
	LoadSelect2_4Script(Select2_4);
	LoadDataTablesScripts(AllTables);
	//LoadBootstrapValidatorScript(mainFormValidator);
});
</script>

