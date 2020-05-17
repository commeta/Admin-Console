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
$xauthtoken= get_xauthtoken();

if(login_check() && isset($_SESSION['md_users']['role']) && $_SESSION['md_users']['role'] == 1){
	$user_id= $_SESSION['md_users']['id'];
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
			case 'save_additional_fields':	// Редактирование, сохранение результата дополнительных полей
				save_additional_fields();
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

?>
