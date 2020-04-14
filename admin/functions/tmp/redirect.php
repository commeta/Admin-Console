<?php
require_once('includes.php');

if(isset($_GET['get_table'])){	// Менеджер обработки ajax запросов от таблиц
	if($_GET['get_table'] == 'ajax'){ // Загрузка Таблицы
		// DB table to use
		$table = 'md_redirect';
		 
		// Table's primary key
		$primaryKey = 'redirect_id';		
				
		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column name in the database, while the `dt` parameter represents the DataTables column identifier. In this case simple indexes
		$columns = array(
			array( 'db' => 'redirect_id', 'dt' => 0 ),
			array( 'db' => 'from_url',  'dt' => 1 ),
			array( 'db' => 'to_url',  'dt' => 2 ),
			array(
				'db'        => 'redirect_id',
				'dt'        => 3,
				'formatter' => function( $d, $row ) {
					return
						sprintf('<center> <a href="javascript:void()" class="ajax-link to" redirect_id="%s" title="Редактировать URL" ><i class="fa fa-edit" ></i></a> |',$d).
						sprintf(' <a href="javascript:void()" class="ajax-link del_url" redirect_id="%s" title="Удалить URL"><i class="fa fa-times" ></i></a></center> ',$d);
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
			$id = $db->insert ('md_redirect', array('to_url'=>"/to_url_".time().'.html', 'from_url'=>"/from_url_".time().'.html' ));
			
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
			
			$db->where('redirect_id', $id );
			$to = $db->getOne('md_redirect');
						
			if($db->count > 0) die(json_encode(array(
				'status'=> isset($status) ? $status : 'url загружен.',
				'css_class'=> 'success',
				'to'=> $to['to_url'],
				'from'=> $to['from_url']
			)));
			die(json_encode(array('status'=>'URL не загружено.','css_class'=>'danger','name'=> '' )));
		}
		
		
		if($_POST['oper'] == 'save_htaccess'){ // Сохранить в файл htaccess
			$md_redirect = $db->get('md_redirect');
			$htaccess= file_get_contents($root_path.'.htaccess');
			$htaccess= preg_replace("/Redirect 301.*\n/", '', $htaccess);
			
			$siteUrl= rtrim(siteUrl, '/');
			
			foreach($md_redirect as $v){
				$htaccess.= sprintf("Redirect 301 %s %s\n", $v['from'],$siteUrl.$v['to'] );
			}
			
			die(json_encode(array('status'=>'htaccess сохранен.','css_class'=>'success','name'=> '' )));
		}
		
		
		
		
		if($_POST['oper'] == 'save_url'){ // Редактирование, сохранение результата
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'URl не сохранено.','css_class'=>'danger')));

			$id = $db->escape($_POST['id']);
			$db->where('redirect_id', $id ); // Сохраним
			
			if($db->update('md_redirect', array(
				'to_url'=>$db->escape($_POST['to']),
				'from_url'=>$db->escape($_POST['from'])
			))){
				die(json_encode(array('status'=>'URl сохранено.','css_class'=>'success')));
			}
			
			die(json_encode(array('status'=>'URl не сохранено.','css_class'=>'danger')));
		}
		
		
		
		if($_POST['oper'] == 'del_url'){ // Удалить
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
			
			$id = $db->escape($_POST['id']);
			$db->where('redirect_id', $id);
			if($db->delete('md_redirect')) die(json_encode(array('status'=>'URL удален.','css_class'=>'success' )));
			
			die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
		}
		
		
		
		
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!','css_class'=>'danger')));
}





/*
$db->where('meta_id > 30');
$md_meta = $db->get('md_meta');

foreach($md_meta as $v){
	echo $v['meta_id'], '<br>';
	echo $v['meta_h1'], '<br>';
	echo $v['friendly_url'], '<br>';
	echo ru2lat2($v['meta_h1']), '<br>';
	
	$db->where('meta_id', $v['meta_id'] );
	$db->update('md_meta', array('friendly_url'=>ru2lat2($v['meta_h1'])));
	
	$id = $db->insert ('md_redirect', array('to_url'=>'/'.ru2lat2($v['meta_h1']).'/', 'from_url'=>'/'.$v['friendly_url'].'/' ));
}
*/




####################################################################### 
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-link"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">SEO</a></li>
			<li><a href="#">Перенаправленные URL</a></li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-sm-12">
			<div class="box box-content bg-tab">
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1"><i class="fa fa-link"></i> Таблица перенаправлений URL</a></li>
						<li><a href="#tabs-2"><i class="fa fa-edit"></i> Редактирование URL</a></li>
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
													<th>From</th>
													<th>To</th>
													<th style="white-space:nowrap; width:130px;">Действия</th>
												</tr>
											</thead>
											<tbody>
												<tr><td></td><td></td><td></td></tr>
											</tbody>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>From</th>
													<th>To</th>
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
										<form method="post" action="" class="form-horizontal ajax-form" name="to">
											<fieldset>
												<legend>Исходный URL</legend>	
													<div class="form-group">
														<label class="col-sm-2 control-label">From</label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="from" />
														</div>
													</div>
												
												<legend>URL назначения</legend>
												<div class="form-group">
													<label class="col-sm-2 control-label">To</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" name="to" />
													</div>
												</div>
											</fieldset>
											
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




<script type="text/javascript">
var st_func= true;
$('#datatable-main').on( 'draw.dt', function () { // При обновлении таблицы
	// Обработчик
	//$('#datatable-main').on('click', 'a', function (e) {
		//e.preventDefault();
		//event.stopPropagation();
		
		//if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
		//st_func= false;
		
		
		//if($(this).hasClass('to')){ // Клик из таблицы, редактирование
		$('#datatable-main .to').click(function(e){
			e.preventDefault();
			event.stopPropagation();
			
			$('form[name="to"]').attr( 'redirect_id', $(this).attr('redirect_id') );
			
			var form_data= new FormData();
			form_data.append("oper", 'load_url');
			form_data.append("id", $(this).attr('redirect_id'));

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
			form_data.append("id", $(this).attr('redirect_id'));

			$('form[name="to"]').attr('redirect_id',"undefined");
			
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
		
	$('form[name="to"] input[name="to"]').val( data.to );
	$('form[name="to"] input[name="from"]').val( data.from );
	
	get_count();
	
	logger(data.status, data.css_class);
}

$('.add-url').click(function(){ // Добавить url
	if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
	st_func= false;

	var form_data= new FormData();
	form_data.append("oper", 'add_url');
			
	saveAndLoadAjaxContent(form_data, function(data){ // Загрузим значение в поле, и переключим на вкладку редактора
		setUpEditor(data);
		
		var table = $('#datatable-main').DataTable(); // Обновить таблицу
		table.draw();
		
		logger(data.status, data.css_class);
		st_func= true;
	});
});


$('.save_htaccess').click(function(){ // // Сохранение файла htaccess
	if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
	st_func= false;
	
	var form_data= new FormData();
	form_data.append("oper", 'save_htaccess');
		
	saveAndLoadAjaxContent(form_data, function(data){
		logger(data.status, data.css_class);
		st_func= true;
	});
});

$('.ajax-form').submit(function(e){ // Перехват отправки форм
	$(this).find('.btn').addClass("btn-danger");
	
	var oper_name=  $(this).attr('name');
	
	if(oper_name == 'to'){ // Сохранение из формы редактирование
		var form_data= new FormData();
		form_data.append("oper", 'save_url');
		form_data.append("id", $(this).attr('redirect_id'));
		form_data.append("to", $('input[name="to"]').val() );
		form_data.append("from", $('input[name="from"]').val() );

		
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
		url: '/admin/functions/redirect.php',
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
	
	$('form[name="to"] select').select2({width: '100%'});
}
 		
// Run Datables plugin and create of settings
function AllTables(){
	$('#datatable-main').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "/admin/functions/redirect.php?get_table=ajax",
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

