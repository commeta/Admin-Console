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


function save_additional_fields(){ // Сохранение дополнительных полей
	if(!isset($_POST['id']) || $_POST['id'] == '' ||  $_POST['id'] == 'undefined') die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
	
	$db = MysqliDb::getInstance();
	$id = $db->escape($_POST['id']);
	
	###### db_table_images
	$db->where('parent_id', $id ); // Список id имеющихся в базе
	$ids= $db->map('id')->ArrayBuilder()->get(db_table_images, null, ['id']);

	foreach(['slider','gallery'] as $images){
		if( !isset($_POST[$images]) ) die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
		$order= 1;
		foreach(json_decode($_POST[$images], true) as $image){
			$image_id= $image['id'];
			unset($image['id']);
			
			if( $image['img_type'] != $images ) die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
			
			foreach($image as &$i) $i= $db->escape($i);
			$image['img_order']= $order;

			if($image_id !== 0 && array_key_exists($image_id, $ids)){ // Update
				unset($ids[$image_id]);
				
				$db->where('id', $image_id );
				if($db->update(db_table_images, $image)){
					die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
				}
			} else { // Insert
				$image['parent_id']= $id;
				$db->insert(db_table_images, $image);
			}
			
			$order++;
		}
	}
	
	if( count($ids) > 0 ){
		$db->where('id', array_keys($ids), 'in');
		$db->delete(db_table_images);
	}
	
	
	###### db_table_additional_fields
	$db->where('parent_id', $id ); // Список id имеющихся в базе
	$ids= $db->map('id')->ArrayBuilder()->get(db_table_additional_fields, null, ['id']);

	foreach(['info','paragraph'] as $fields){
		if( !isset($_POST[$fields]) ) die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
		$order= 1;
		foreach(json_decode($_POST[$fields], true) as $field){
			$field_id= $field['id'];
			unset($field['id']);
			
			if( $field['field_type'] != $fields ) die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
			
			foreach($field as &$i) $i= $db->escape($i);
			$field['field_order']= $order;

			if($field_id !== 0 && array_key_exists($field_id, $ids)){ // Update
				unset($ids[$field_id]);
				
				$db->where('id', $field_id );
				if($db->update(db_table_additional_fields, $field)){
					die(json_encode(array('status'=>'Страница не сохранена.','css_class'=>'danger')));
				}
			} else { // Insert
				$field['parent_id']= $id;
				$db->insert(db_table_additional_fields, $field);
			}
			
			$order++;
		}
	}
	
	if( count($ids) > 0 ){
		$db->where('id', array_keys($ids), 'in');
		$db->delete(db_table_additional_fields);
	}
	
	clean_cache();
	die(json_encode(array('status'=>'Страница сохранена.','css_class'=>'success')));
}


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
