"use strict";

(function($) {	// Загрузка шрифта
	function createStyle(txt) {
		var style = document.createElement('style');
		style.textContent = txt;
		style.rel = 'stylesheet';
		document.head.appendChild(style);
	}

	var fontLsKey = 'sourceFontsRobotoV1';
	
	if(localStorage[fontLsKey]) {
		createStyle(localStorage[fontLsKey]);
	} else {
		var data = {
			'ajax': true,
			'oper': 'get_font',
			'url':	'https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i,900&display=swap&subset=cyrillic,cyrillic-ext'
		}
		
		$.ajax({
			url:'/ajax.php',
			data: data,
			type:'post',
			success:function(data){
				localStorage[fontLsKey] = data;
				createStyle(data);
			}
		});
	}
	
	$('input[name="username"]').val("username");
	$('input[name="password"]').val("password");
	
	
})(jQuery);


