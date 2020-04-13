"use strict";
//var $ = jQuery;

(function($) {	
	function createStyle(txt) {
		var style = document.createElement('style');
		style.textContent = txt;
		style.rel = 'stylesheet';
		document.head.appendChild(style);
	}

	var fontLsKey = 'sourceFontsRobotoV5';
	
	if(localStorage[fontLsKey]) {
		createStyle(localStorage[fontLsKey]);
	} else {
		var data = {
			'ajax': true,
			'oper': 'get_font'
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
})(jQuery);


