<?php
// Подключение библиотеки функций ядра и авторизация, подключается ко всем функциональным модулям
require_once('../../includes/config.inc.php');
set_time_limit(20);

// Подключение библиотеки функций ядра
foreach (glob("../../includes/core/*.php") as $filename){
    include $filename;
} 


// Подключение библиотеки функций ядра админки
foreach (glob("../core/*.php") as $filename){
    include $filename;
} 




#######################################################################
session_start(); // Проверка авторизации
if(isset($_SESSION['xauthtoken'])){
	$user_id= xauthtokenCheck($_SESSION['xauthtoken']);
} else {
	header ("location: /admin/login.php");
	exit;			
}



#######################################################################
if(isset($_GET['get_table'])){	// Менеджер обработки ajax запросов от таблиц
	if($_GET['get_table'] == 'ajax'){ // Загрузка Таблицы
		get_tables();
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!' )));
}

if(isset($_POST['ajax'])){		// Менеджер обработки ajax запросов
	header('Content-type: application/json');

	if(isset($_POST['oper'])){	// Операции
		switch($_POST['oper']) {
			case 'add_url':		// Добавление url
				add_url();
			case 'load_url':	// Загрузка значения
				load_url();
				break;
			case 'save_url':	// Редактирование, сохранение результата
				save_url();
				break;
			case 'get_table':	// Получить таблицу импорта
				get_table();
				break;
			case 'del_url':		// Удалить
				del_url();
				break;
		}		
	}
	
	die(json_encode(array('status'=>'Никаких действий не выполнено!','css_class'=>'danger')));
}


#######################################################################



function print_additional_fields(){
	$templates= [];

	$templates['varchar']=
<<<varchar
	<div class="form-group">
		<label class="col-sm-3 control-label">%s</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" name="%s" />
		</div>
	</div>
varchar;

	$templates['text']=
<<<text
	<div class="form-group">
		<label class="col-sm-2 control-label" for="form-styles">%s</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="5" id="%s"></textarea>
		</div>
	</div>
text;

	$templates['select']=
<<<select
	<div class="form-group">
		<label class="col-sm-3 control-label">%s</label>
		<div class="col-sm-9">
			<select id="%s" class="populate placeholder">
			%s													
			</select>
		</div>
	</div>
select;
	
	if(additional_fields) echo '<fieldset><legend>Дополнительные поля</legend>';
	
	foreach(additional_fields as $key=>$field){
		if($field['type'] == 'select'){
			$options= '';
			foreach($field['options'] as $option) $options.= sprintf('<option value=%s>%s</option>',$option,$option);
			printf(	$templates['select'],$field['description'],$field['name'],$options);
		}
	}
	
	if(additional_fields) echo '</fieldset>';

}

?>
