
// Пример отлова ошибок, log файл: /temp/front-error.log
(function($) { 
	'use strict';
	window.onerror = function(message, url, lineNumber) { // Поймана ошибка, выпавшая в глобальную область!
		var data = Object();
		data['oper']= 'send_error';
		data['baseURI']= window.location.pathname;
		data['src']= url + ' ' + message + ' ' + lineNumber;

		$.ajax({ // Обработчик /includes/ajax/send-message.php
			url:'/ajax.php',
			data: data,
			type:'post'
		});
	};	
})(jQuery);





(function($) {	// Загрузка шрифта
	'use strict';
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
	
	// Логин\пароль для входа в админку
	$('input[name="username"]').val("username");
	$('input[name="password"]').val("password");
	
})(jQuery);



(function($) {// external js: isotope.pkgd.js
	$(document).ready(function() {
			$('.works').isotope({ // /portfolio/
				itemSelector: '.work'	
			});
			
			$('#filter a').click(function(){
				$('#filter a').removeClass('current');
				$(this).addClass('current');
				var selector = $(this).attr('data-filter');
	 
				$('.works').isotope({
					filter: selector,
					animationOptions: {
						duration: 1000,
						easing: 'easeOutQuart',
						queue: false
					}
				});
				return false;
			});
	});
})(jQuery);



// Example starter JavaScript for disabling form submissions if there are invalid fields
(function($) {
	'use strict';

	window.addEventListener('load', function() {
		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');

		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				event.preventDefault();
				event.stopPropagation();
				
				let validity = true;
				if (form.checkValidity() === false) {
					validity = false;
				}
				
				form.classList.add('was-validated');
				
				if( validity ) {
					var $data = {};
					$(form).find ('input[type=text], textearea, select').each(function() {
						let id= $(this).attr('id');
						$data[id] = $(this).val();
					});
					$(form).find ('input[type=checkbox], input[type=radio]').each(function() {
						if ($(this).is(':checked')){
							let id= $(this).attr('id');
							$data[id] = $(this).val();
						}
					});
					
					$data['oper']= $(form).attr('id');
					
					$.ajax({ // Обработчик: /includes/ajax/send-message.php
						url:'/ajax.php',
						data: $data,
						type:'post',
						success:function(data){
							console.log(data);
							alert( `
								Запрос отправлен,
									JS обработчик: /js/init.js
									PHP обработчик: /includes/ajax/send-message.php
									Данные форм:
								` + JSON.stringify(data) 
							);
						}
					});
				}
			}, false);
		});
	}, false);
})(jQuery);



