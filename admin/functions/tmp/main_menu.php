<?php
require_once('includes.php');


//https://github.com/ilikenwf/nestedSortable
$root_path = (preg_match('/\/$/',$_SERVER['DOCUMENT_ROOT']))?$_SERVER['DOCUMENT_ROOT']:$_SERVER['DOCUMENT_ROOT'].'/';


if(isset($_POST['hiered']) ){
	
		if(file_exists($root_path.'templates/chanks/main-menu.html')){
			//$contenttab= str_replace(array("\r\n", "\r", "\n","\t"), '',  $_POST['hiered']);
			//$contenttab= str_replace('  ', ' ',  $contenttab);
			$contenttab= $_POST['hiered'];
			
			file_put_contents($root_path.'templates/chanks/main-menu.html', $contenttab);
			die(json_encode(array('status'=>'Меню успешно сохранено', 'contenttab'=>$contenttab)));
		}
	
	die(json_encode(array('status'=>'Ошибка !')));
}

//$menu= $modx->getChunk('menu-site');
if(file_exists($root_path.'templates/chanks/main-menu.html')){
	$menu= file_get_contents($root_path.'templates/chanks/main-menu.html');
}






?>
<script src="/admin/js/jquery.mjs.nestedSortable.js"></script>
<select id="friendly_url" class="hidden">
<?php 
$md_meta= $db->get("md_meta", null, ['friendly_url','meta_h1']);
foreach($md_meta as $v){printf('<option value=%s>%s</option>',$v['friendly_url'], $v['meta_h1']);}
?>
</select>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-globe"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Меню сайта</a></li>
			<li><a href="#">Главное меню</a></li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-home"></i>
					<span>Главное меню сайта</span>
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
			<div class="box-content">
				
				
				
				<div id="JqueryMenu" style="width:90%; height:auto; text-align: left;">
				<?php
					echo $menu;
				?>

					<div class="menuManager">
						<a href="javascript:void(0);" class="addMenu">Добавить пункт</a><br />
						<a href="javascript:void(0);" class="saveMenu">Сохранить</a>
						<div class="menuManagerSave"></div>
					</div>
					<br /><br />
				</div>

				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
function changeTitle(counterId){
	$("#menuItem_"+counterId+" .itemTitle").text(  $("input[name=title-"+counterId+"]").val()    );
}





$().ready(function(){
	// Menu parse
	var counterId= 1;
	
	function parseMenu(menu,level){// Обвязка меню
		var filled= false;
		
		$( menu ).children("li").each(function(indx, element){
			var li= $(element).html();
			
			matches = li.match(/<a.*?>(.*?)<\/a>/);
			if(!matches) return false
			title= matches[1];
			//else title= "untitled";
			
			matches = li.match(/<a href="(.*?)".*?>/);
			if(matches) href= matches[1];
			else href= "nohref";
			
			$(element).attr({"id":"menuItem_" + counterId});
			
			$(element).children("a").replaceWith('<div class="menuDiv"><span data-id="'
				+ counterId
				+ '" class="expandEditor ui-icon"><span></span></span><span><span data-id="'
				+ counterId
				+ '" class="itemTitle">'
				+ title +'</span><span data-id="'
				+ counterId
				+ '" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span><div id="menuEdit'
				+ counterId
				+ '" class="menuEdit hidden">'
				+ 'Дружественные URL: <select counterId="'+counterId+'" class="populate placeholder select friendly-select"></select><br />'
				+ 'Ссылка: <input name="href-'+counterId+'" value="'+href+'"><br />'
				+ 'Текст ссылки: <input onchange="changeTitle(' + counterId + ')" name="title-'+counterId+'" value="'+title+'">'
				+ '</div></div>'
			);
			
			counterId++;
			if(li.indexOf('<ul>') != -1){
				$(element).addClass('mjs-nestedSortable-branch mjs-nestedSortable-expanded');
				parseMenu( $(element).children("ul"),level + 1 );
			} else {
				$(element).addClass('mjs-nestedSortable-leaf');
			}
			
			filled= true;
		});
		return filled;
	}
	parseMenu( $('#JqueryMenu ul:first-child'), 0 );
	
	$('#JqueryMenu ul:first-child').addClass('sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded');

	var ns = $('#JqueryMenu ul').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		listType: 'ul',
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 8,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: false
	});




		function dump(arr,level) {
			var dumped_text= [];
			if(!level) level = 0;
	
			if(typeof(arr) == 'object') { //Array/Hashes/Objects
				for(var item in arr) {
					var value = arr[item];
					
					if(typeof(value) == 'object') { //If it is an array,
						if( typeof(value.id) == 'string' ){
							var nextlvl= dump(value,level+1);
							
							if( nextlvl.length !== 0 ) {
								dumped_text.push( [$("input[name=href-"+value.id+"]").val(), $("input[name=title-"+value.id+"]").val(), nextlvl ]  );	
							} else {
								dumped_text.push( [$("input[name=href-"+value.id+"]").val(), $("input[name=title-"+value.id+"]").val()]  );
							}
						} else {
							for(var i= 0; i < value.length; i++ ){
								if( typeof(value[i]) == 'object' ){
									if( typeof(value[i].id) == 'string' ){
										dumped_text.push( [$("input[name=href-"+value[i].id+"]").val(), $("input[name=title-"+value[i].id+"]").val() ] );
									}
								}
							}
						}
					} else {
						//dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
					}
				}
			} else { //Strings/Chars/Numbers etc.
				//dumped_text[] = "===>"+arr+"<===("+typeof(arr)+")";
			}
			
			return dumped_text;
		}
		
	function create_munu(dmp){
		var txt= '';
		$.each( dmp, function(key, val) { //
			if( typeof(val) == 'object' ){
				if(typeof(val[0]) == 'string'){
					txt += '<li><a href="'+val[0]+'">'+val[1]+'</a>';
					
					if( typeof(val[2]) == 'object' ) {
						txt += create_munu( val[2] );
					}
					txt += '</li>';
				}
			}
		});
		return '<ul>'+txt+'</ul>';
	}
	
	$('.saveMenu').click(function(e){
		hiered = $('#JqueryMenu ul').nestedSortable('toHierarchy', {startDepthCount: 0});
		
		var form_data = new FormData();
		//var menuStr= $('#JqueryMenu ul').html();
		var dmp= dump(hiered);
		var menuStr= create_munu(dmp);
		
		form_data.append("hiered", menuStr );
		
		$.ajax({
			url: "/admin/functions/main_menu.php",
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: "post",
			success: function(response){
				$(".menuManagerSave").text(response.status).stop(true,true).fadeIn(0).fadeOut(6000);
				//console.log( response );
			}
		 });
	});	
		
	function menuGen(){
		$('.expandEditor').attr('title','Click to show/hide item editor');
		$('.disclose').attr('title','Click to show/hide children');
		$('.deleteMenu').attr('title', 'Click to delete item.');
		
		$('.disclose').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
			$(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
		});
				
		$('.expandEditor, .itemTitle').click(function(e){
			var id = $(this).attr('data-id');
			$('#menuEdit'+id).toggleClass('hidden');
			$(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
		});
		
		$('.deleteMenu').click(function(){
			var id = $(this).attr('data-id');
			$('#menuItem_'+id).remove();
		});
		
		$.each($('.friendly-select'),function(index,value){
			
			$(this).html( $('#friendly_url').html() );
			
		});
		LoadSelect2_4Script(Select2_4);
		
	}	
		
	menuGen();
	$('.menuEdit').toggle();
	
	
	
	
	
	
		
	$('.addMenu').click(function(){
		counterId++;
		var menuDiv= '<div class="menuDiv"><span data-id="'
			+ counterId
			+ '" class="expandEditor ui-icon ui-icon-triangle-1-n ui-icon-triangle-1-s"><span></span></span><span><span data-id="'
			+ counterId
			+ '" class="itemTitle">'
			+ 'TITLE</span><span data-id="'
			+ counterId
			+ '" class="deleteMenu ui-icon ui-icon-closethick"><span></span></span><div id="menuEdit'
			+ counterId
			+ '" class="menuEdit hidden">'
			+ 'Дружественные URL: <select counterId="'+counterId+'" class="populate placeholder select friendly-select"></select><br />'
			+ 'Ссылка: <input name="href-'+counterId+'" value=""><br />'
			+ 'Текст ссылки: <input onchange="changeTitle(' + counterId + ')" name="title-'+counterId+'" value="">'
			+ '</div></div>';
		$('#JqueryMenu .sortable').append('<li id="menuItem_'+ counterId +'" class="mjs-nestedSortable-leaf">'+menuDiv+'</li>');
		
		menuGen();
	});
				
		
	$(window).keydown(function(event){ //ловим событие нажатия клавиши
		if(event.keyCode == 13) { //если это Enter
			$('#edit').blur(); //снимаем фокус с поля ввода
		}
	});	
});			



// Run Select2 plugin on elements
function Select2_4(){
	$('.select').select2({
		placeholder: "Выбор",
		allowClear: true,						
		tags: true,
		tokenSeparators: [',', ' '],
		width: '550px'
		//data: data.clinic_specialism
	});
	
	
		// Bind an event
		$('.select').on('select2:select', function (e) { 
			var data = e.params.data;
			
			$("input[name=href-"+$(this).attr('counterId')+"]").val( data.element.value  );
			$("input[name=title-"+$(this).attr('counterId')+"]").val( data.element.innerHTML  );
		});
	
	
}

	
	


$(document).ready(function () {
	// Add Drag-n-Drop feature
	//WinMove();
	LoadSelect2_4Script(Select2_4);
});



</script>
<style>
.placeholder {
	outline: 1px dashed #4183C4;
}
.mjs-nestedSortable-error {
	background: #fbe3e4;
	border-color: transparent;
}
#tree {
	width: 850px;
	margin: 0;
}
ol, ul {
	max-width: 850px;
	padding-left: 25px;
}
ol.sortable,ol.sortable ol, ul.sortable,ul.sortable ul {
	list-style-type: none;
}
.sortable li div {
	border: 1px solid #d4d4d4;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	cursor: move;
	border-color: #D4D4D4 #D4D4D4 #BCBCBC;
	margin: 0;
	padding: 3px;
	text-align: right;
}
.sortable li div input{
	width: 550px;
}
li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
	border-color: #999;
}
.disclose, .expandEditor {
	cursor: pointer;
	width: 20px;
	display: none;
}
.sortable li.mjs-nestedSortable-collapsed > ol {
	display: none;
}
.sortable li.mjs-nestedSortable-branch > div > .disclose {
	display: inline-block;
}
.sortable span.ui-icon {
	display: inline-block;
	margin: 0;
	padding: 0;
}
.menuDiv {
	background: #EBEBEB;
}
.menuEdit {
	background: #FFF;
}
.itemTitle {
	vertical-align: middle;
	cursor: pointer;
}
.deleteMenu {
	float: right;
	cursor: pointer;
}
.addMenu {
	cursor: pointer;
}
.ui-icon-minusthick {
    background-position: -64px -128px;
}
.ui-icon-triangle-1-n {
    background-position: 0 -16px;
}
.ui-icon-closethick {
    background-position: -96px -128px;
}
.ui-icon-plusthick {
    background-position: -32px -128px;
}
.ui-icon-triangle-1-s {
    background-position: -64px -16px;
}
.ui-icon-addthick {
    background-position: -33px -128px;
}
.ui-icon, .ui-widget-content .ui-icon {
    background-image: url('//code.jquery.com/ui/1.10.4/themes/smoothness/images/ui-icons_222222_256x240.png');
}	
.ui-icon {
    width: 16px;
    height: 16px;
}
.ui-icon {
    display: block;
    text-indent: -99999px;
    overflow: hidden;
    background-repeat: no-repeat;
}
.menuManager {
    position: absolute;
    width: 160px;
    height: 65px;
    background: #ccc;
    top: 30%;
    right: 20%;
    text-align: center;
    padding: 15px;
}
.dashboard-block-double, .dashboard-block .body{
	min-height: 700px;
}
</style>
