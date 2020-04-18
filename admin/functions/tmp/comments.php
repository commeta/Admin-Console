<?php
require_once('includes.php');

if(isset($_GET['get_table'])){	// Менеджер обработки ajax запросов от таблиц
	if($_GET['get_table'] == 'ajax'){ // Загрузка Таблицы
		// DB table to use
		$table = 'md_comments';
		 
		// Table's primary key
		$primaryKey = 'msg_id';		
				
		// Array of database columns which should be read and sent back to DataTables. 
		// The `db` parameter represents the column msg_text in the database, while the `dt` parameter represents the DataTables column identifier. In this case simple indexes
		$columns = array(
			array( 'db' => 'msg_id', 'dt' => 0 ),
			array(
				'db'        => 'approved',
				'dt'        => 1,
				'formatter' => function( $d, $row ) {
					return $row['approved'] == 0 ? 'не одобрено' : 'одобрено';
				}
			),
			array(
				'db'        => 'msg_text',
				'dt'        => 2,
				'formatter' => function( $d, $row ) {
					return mb_strlen($row['msg_text']) < 90 ? $row['msg_text'] : mb_substr($row['msg_text'], 0, 90).'...';
				}
			),
			array(
				'db'        => 'msg_id',
				'dt'        => 3,
				'formatter' => function( $d, $row ) {
					return
						sprintf(' <center><a href="javascript:void()" class="ajax-link edit_comments" msg_id="%s" title="Редактировать отзыв" ><i class="fa fa-edit" ></i></a> |',$d).
						sprintf(' <a href="javascript:void()" class="ajax-link del_comments" msg_id="%s" title="Удалить отзыв"><i class="fa fa-times" ></i></a></center> ',$d);
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
		if($_POST['oper'] == 'load_comments'){ // Загрузка значения
			$id = $db->escape($_POST['id']);
					
			$db->where("msg_id", $id );
			$md_comments = $db->getOne("md_comments");
						
			if($db->count > 0) die(json_encode(array(
				'status'=>'отзыв загружен.',
				'css_class'=>'success',
				'comment'=>$md_comments
			)));
			die(json_encode(array('status'=>'отзыв не загружен.','css_class'=>'danger','msg_text'=> '' )));
		}
		
		
		
		if($_POST['oper'] == 'edit_comments'){ // Редактирование, сохранение результата
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'отзыв не сохранен.','css_class'=>'danger')));
			
			$id = $db->escape($_POST['id']);
			
			$msg_text = str_replace(array("\r\n", "\r", "\n"), ' ',  htmlspecialchars(strip_tags($_POST['msg_text'])));
			$msg_text = $db->escape($msg_text);
			
			$approved= $db->escape($_POST['approved']);
			
			$db->where('msg_id', $id );
			if($db->update('md_comments', array('msg_text'=>$msg_text, 'approved'=>$approved ))) die(json_encode(array('status'=>'отзыв сохранен.','css_class'=>'success')));
			die(json_encode(array('status'=>'отзыв не сохранен.','css_class'=>'danger')));
		}
				
		if($_POST['oper'] == 'del_comments'){ // Удалить, отзыв
			if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'отзыв не удален.','css_class'=>'danger')));
			
			$id = $db->escape($_POST['id']);
			$db->where('msg_id', $id);
			if($db->delete('md_comments')) die(json_encode(array('status'=>'отзыв удален.','css_class'=>'success', 'msg_text'=> $_POST['id'] )));
			
			die(json_encode(array('status'=>'отзыв не удален.','css_class'=>'danger')));
		}
		
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!','css_class'=>'danger')));
}

#######################################################################
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-star-half-o"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Посетители</a></li>
			<li><a href="#">Отзывы</a></li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-sm-12">
			<div class="box box-content bg-tab">
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1"><i class="fa fa-star-half-o"></i> Отзывы</a></li>
						<li><a href="#tabs-2"><i class="fa fa-edit"></i> Редактирование отзыва</a></li>
					</ul>
					<div id="tabs-1">
						<!-- Таблица -->				
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<div class="box-msg_text">
											<i class="fa fa-star-half-o"></i>
											<span>Отзывы</span>
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
													<th style="white-space:nowrap; width:130px;">Статус</th>
													<th>Название</th>
													<th style="white-space:nowrap; width:130px;">Действия</th>
												</tr>
											</thead>
											<tbody>
												<tr><td></td><td></td><td></td></tr>
											</tbody>
											<tfoot>
												<tr>
													<th>ID</th>
													<th>Статус</th>
													<th>Название</th>
													<th>Действия</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- /Таблица -->				
					</div>
					<div id="tabs-2">
						<!-- Редактирование -->				
						<div class="row">
							<div class="col-xs-12 col-sm-12">
									<div class="box box-content bg-tab">
										<form method="post" action="" class="form-horizontal ajax-form validator" name="edit_comments">
											<fieldset>
												<legend>Источник</legend>
												
												<div class="form-group">
													<label class="col-sm-3 control-label">От пользователя</label>
													<div class="col-sm-8">
														<div id="user_name"></div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Дата публикации</label>
													<div class="col-sm-8">
														<div id="public_time"></div>
													</div>
												</div>






												
												
												<legend>Редактировать</legend>
												<div class="form-group">
													<label class="col-sm-3 control-label">Редактировать отзыв</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="5" id="msg_text"></textarea>
													</div>
												</div>
												
												
												

					
												
											</fieldset>
											
											
											
											
											
											
											<div class="form-group">
												<div class="col-sm-3 col-sm-offset-3">
													<div class="toggle-switch toggle-switch-success">
														<label>
															<input type="checkbox" id="approved" name="toggle-switch" >
															<div class="toggle-switch-inner"></div>
															<div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
														</label>
													</div>
												</div>
												
												<div class="col-sm-5">
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
						<!-- /Редактирование -->				
					</div>
				</div>
			</div>
	</div>
</div>

<style>
.toggle-switch-inner::before {
    content: "Одобрено";
}
.toggle-switch-inner::after {
    content: "Удалить";
}
.toggle-switch {
    width: 97px;
}
.toggle-switch-switch {
    right: 76px;
}
</style>


<script type="text/javascript">
var st_func= true;
$('#datatable-main').on( 'draw.dt', function () { // При обновлении таблицы

	// Обработчик
	$('#datatable-main').on('click', 'a', function (e) {
		e.preventDefault();
		event.stopPropagation();
		
		if(!st_func) return false; // Запрет на запуск пока предыдущий запрос не отработал
		st_func= false;
		
		if($(this).hasClass('edit_comments')){ // Клик из таблицы, редактирование
			$('form[name="edit_comments"]').attr( 'msg_id', $(this).attr('msg_id') );
			
			var form_data= new FormData();
			form_data.append("oper", 'load_comments');
			form_data.append("id", $(this).attr('msg_id'));

			saveAndLoadAjaxContent(form_data, function(data){ // Загрузим значение в поле, и переключим на вкладку редактора
				$("#tabs").tabs('enable',1);
				$('#tabs').tabs("option", "active", 1);
				
				console.log(data);
				
				$('#user_name').text( data.comment.user_name );
				
				$('#public_time').text( data.comment.public_time );
				
				if( data.approved ) $('#approved').prop('checked', true);
				else $('#approved').prop('checked', false);
				
				$('#msg_text').val( data.comment.msg_text );
				
				logger(data.status, data.css_class);
				st_func= true;
			});
			return false;
		}
		
		if($(this).hasClass('del_comments')){ // Клик из таблицы, удаление
			var form_data= new FormData();
			form_data.append("oper", 'del_comments');
			form_data.append("id", $(this).attr('msg_id'));
			
			$('form[name="edit_comments"]').attr('msg_id',"undefined");
			
			saveAndLoadAjaxContent(form_data, function(data){ // Удаляем отзыв
				logger(data.status, data.css_class);
				
				var table = $('#datatable-main').DataTable(); // Обновить таблицу
				table.draw(); 
				st_func= true;
			});
			return false;
		}
		
		return false;
	});
});





$('.ajax-form').submit(function(e){ // Перехват отправки форм
	$(this).find('.btn').addClass("btn-danger");
	
	var oper_msg_text=  $(this).attr('name');
	
	if(oper_msg_text == 'edit_comments'){ // Сохранение из формы редактирование отзыва
		var form_data= new FormData();
		form_data.append("oper", 'edit_comments');
		form_data.append("id", $(this).attr('msg_id'));
		form_data.append("msg_text", $('#msg_text').val() );
		
		if($('#approved').prop('checked')) form_data.append("approved", 1);
		else form_data.append("approved", 0);
		
		saveAndLoadAjaxContent(form_data, function(data){
			logger(data.status, data.css_class);
			$('form[name="'+oper_msg_text+'"]').find('.btn').removeClass("btn-danger");
			$('form[name="'+oper_msg_text+'"]').find('.btn').prop('disabled',false);

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
		url: '/admin/functions/comments.php',
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

// Run Datables plugin and create of settings
function AllTables(){
	$('#datatable-main').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "/admin/functions/comments.php?get_table=ajax",
		"aaSorting": [[ 0, "asc" ]],
		"sDom": "<'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sSearch": "Поиск по базе: ",
			"sLengthMenu": '_MENU_'
		},

        dom: 'Bfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data'
        } ]

	});
}

$(document).ready(function() {
	LoadDataTablesScripts(AllTables);
	//LoadBootstrapValidatorScript(mainFormValidator);
});
</script>

