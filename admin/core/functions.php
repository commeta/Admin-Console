<?php
function check_template($url){ // Если URL шаблона то удалять нельзя !
	if(db_table != 'md_meta') return true;
	
	static $files= [];
	
	if(!$files){
		foreach(glob("../../templates/*.php") as $filename){
			$files[]= '/'.str_replace('.php','.html',basename($filename));
			$files[]= '/'.str_replace('.php','/',basename($filename));
		}
	}
	
	foreach($files as $filename){
		if($filename==$url) return false;
	}
	
	return true;
}


function get_tables(){ // Менеджер обработки ajax запросов от таблиц
	// SQL server connection information, for table()
	// https://www.datatables.net/manual/api
	// https://github.com/DataTables/DataTables/blob/master/examples/server_side/scripts/ssp.class.php
	// https://github.com/emran/ssp
	$sql_details = array('user' => db_login, 'pass' => db_pass,'db' => db_dbname,'host' => db_host);		
	
	
	// DB table to use
	$table = db_table;
		 
	// Table's primary key
	$primaryKey = 'id';		
				
	// Array of database columns which should be read and sent back to DataTables. 
	// The `db` parameter represents the column name in the database, while the `dt` parameter represents the DataTables column identifier. In this case simple indexes
	$columns = array(
		array( 'db' => 'id', 'dt' => 0 ),
		//array( 'db' => 'friendly_url',  'dt' => 1 ),
		array(
			'db'        => 'friendly_url',
			'dt'        => 1,
			'formatter' => function( $d, $row ) {
				return
					sprintf('<a href="%s" class="ajax-link open_page" target="_BLANC" >%s</a>',$d,$d);
			}
		),
		array( 'db' => 'meta_title',  'dt' => 2 ),
		array(
			'db'        => 'id',
			'dt'        => 3,
			'formatter' => function( $d, $row ) {
				return
					(
						check_template($row['friendly_url'])
						?
							sprintf(' <center><a href="javascript:void()" onclick="edit_url(%s,false);return false" class="ajax-link friendly_url" meta_id="%s" title="Редактировать URL" >Правка</a> ',$d,$d).
							sprintf('| <a href="javascript:void()" onclick="del_url(%s);return false" class="ajax-link del_url" meta_id="%s" title="Удалить URL">Удалить</a></center> ',$d,$d)
						:
							sprintf(' <center><a href="javascript:void()" onclick="edit_url(%s,true);return false" class="ajax-link friendly_url" meta_id="%s" title="Редактировать URL" >Правка</a> ',$d,$d).
							'</center>'
					);
			}
		)
	);
		
	$result= SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
	die(json_encode($result) );	
}


function add_url(){ // Добавление url
	$db = MysqliDb::getInstance();
	
	$id = $db->insert(db_table, array('friendly_url'=>root_path_url."new_url_".time().".html", 'meta_title'=>"Новый URL ".date("d.m.y H:i:s") ));
	$_POST['id']= $id;
			
	if($id) {
		$_POST['oper']= 'load_url';
		$_POST['id']= $id;
		$_POST['status']= 'Добавление и загрузка url в редактор';
		clean_cache();
	} else {
		die(json_encode(array('status'=>'Новый url не создан.','css_class'=>'danger')));
	}
}


function load_url(){ // Загрузка значения
	$db= MysqliDb::getInstance();
	$add= [];
	$id= $db->escape($_POST['id']);

	$db->where('parent_id', $id );
	$images= $db->get(db_table_images);
	if($db->count > 0){ // Дополнительные поля, изображения Слайдер\Галерея
		$add['images']= $images;
	}
	
	$db->where('parent_id', $id );
	$fields= $db->get(db_table_additional_fields);
	if($db->count > 0){ // Дополнительные поля, Инфоблоки\Параграфы
		$add['fields']= $fields;
	}

	$db->where('id', $id );
	$friendly_url= $db->getOne(db_table);

	if($db->count > 0) {
		die(json_encode(array(
			'status'=> $_POST['status'] ?? 'url загружен.',
			'css_class'=> 'success',
			'friendly_url'=> $friendly_url['friendly_url'],

			'meta_h1'=> $friendly_url['meta_h1'],
			'meta_title'=> $friendly_url['meta_title'],
			'meta_description'=> $friendly_url['meta_description'],
			'meta_keywords'=> $friendly_url['meta_keywords'],
			'meta_text'=> $friendly_url['meta_text'],
			'content'=> $friendly_url['content'],
			'image'=> $friendly_url['image'],
			'id'=> $friendly_url['id']
		) + $add));
	}
	die(json_encode(array('status'=>'URL не загружено.','css_class'=>'danger','name'=> '' )));
}


function save_url(){ // Редактирование, сохранение результата
	if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
	$db = MysqliDb::getInstance();
	$id = $db->escape($_POST['id']);
	$db->where('id', $id ); // Сохраним
		
	if($db->update(db_table, array(
		'friendly_url'=>$db->escape($_POST['friendly_url']),
		'meta_h1'=>$db->escape($_POST['meta_h1']),
		'meta_title'=>$db->escape($_POST['meta_title']),
		'meta_description'=>$db->escape($_POST['meta_description']),
		'meta_keywords'=>$db->escape($_POST['meta_keywords']),
		'meta_text'=>$db->escape($_POST['meta_text']),
		'content'=>$db->escape(str_replace(["\r\n","\n"],'',$_POST['content'])),
		'image'=>$db->escape($_POST['image'])
	))){
		clean_cache();
		die(json_encode(array('status'=>'Страница сохранена.','css_class'=>'success')));
	}
			
	die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
}


function save_additional_fields(){
	if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
	$db = MysqliDb::getInstance();
	$id = $db->escape($_POST['id']);
	
	
	
	//print_r( json_decode($_POST['slider']) );
	//print_r( json_decode($_POST['gallery']) );
	//print_r( json_decode($_POST['info']) );
	//print_r( json_decode($_POST['paragraph']) );
	
	die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger', $_POST['slider'], $_POST['gallery'], $_POST['info'], $_POST['paragraph'])));
	
}

/*
Array
(
    [img_type-1] => slider
    [img_alt-1] => Generic placeholder image
    [img_src-1] => data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==
    [img_type-0] => slider
    [img_alt-0] => Generic placeholder image
    [img_src-0] => data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==
    [img_type-2] => slider
    [img_alt-2] => Generic placeholder image
    [img_src-2] => data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==
    [img_type-3] => slider
    [img_alt-3] => Generic placeholder image
    [img_src-3] => /img/uploads/seo_vse_napravlenia_rabot_nad_proektom.jpg
    [field_type-0] => info
    [field_link_url-0] => #
    [field_link_title-0] => Подробнее »
    [field_header-0] => Разработка
    [field_type-1] => info
    [field_link_url-1] => #
    [field_link_title-1] => Подробнее »
    [field_header-1] => Оптимизация
    [field_type-2] => info
    [field_link_url-2] => #
    [field_link_title-2] => Подробнее »
    [field_header-2] => Продвижение
    [field_type-3] => paragraph
    [field_link_url-3] => /img/uploads/seo_vse_napravlenia_rabot_nad_proektom.jpg
    [field_link_title-3] => 
    [field_header-3] => Интернет маркетинг
    [field_type-4] => paragraph
    [img_alt-4] => Generic placeholder image
    [img_src-4] => /img/uploads/CSS_Shorthand_Cheat_Sheet.jpg
    [field_link_url-4] => /img/uploads/CSS_Shorthand_Cheat_Sheet.jpg
    [field_link_title-4] => 
    [field_header-4] => Разработка шаблона
    [field_type-5] => paragraph
    [img_alt-5] => Generic placeholder image
    [img_src-5] => /img/uploads/JatuTLPbK7w.jpg
    [field_link_url-5] => /img/uploads/JatuTLPbK7w.jpg
    [field_link_title-5] => 
    [field_header-5] => Настройка сервера
    [oper] => save_additional_fields
    [ajax] => true
    [id] => 1
)
*/

function get_table(){ // Получить таблицу импорта
	$db = MysqliDb::getInstance();
	$md_meta= $db->get(db_table, null, ['id','meta_h1']);
	die(json_encode(array('status'=>'Таблица получена.','css_class'=>'success', 'import'=>$md_meta)));
}


function del_url(){ // Удалить
	if(!isset($_POST['id']) || $_POST['id'] == '' || $_POST['id'] == 'undefined') die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
	$db = MysqliDb::getInstance();
		
	$id = $db->escape($_POST['id']);
	$db->where('id', $id);
	if($db->delete(db_table)) {
		clean_cache();
		die(json_encode(array('status'=>'URL удален.','css_class'=>'success' )));
	}
			
	die(json_encode(array('status'=>'URL не удален.','css_class'=>'danger')));
}

?>
