var ajax_url_path= '/ajax.php';


// Пример отлова ошибок, log файл: /temp/front-error.log
(function($) { 
	'use strict';
	window.onerror = function(message, url, lineNumber) { // Поймана ошибка, выпавшая в глобальную область!
		var data = Object();
		data['oper']= 'send_error';
		data['baseURI']= window.location.pathname;
		data['src']= url + ' ' + message + ' ' + lineNumber;

		$.ajax({ // Обработчик /includes/ajax/send-message.php
			url: ajax_url_path,
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
			url: ajax_url_path,
			data: data,
			type:'post',
			success:function(data){
				localStorage[fontLsKey] = data;
				createStyle(data);
			}
		});
	}
	
	// Логин\пароль для входа в админку
	$('input[name="username"]').val("admin");
	$('input[name="password"]').val("password");
	
})(jQuery);



(function($) {// external js: isotope.pkgd.js
	'use strict';

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

	$(document).ready(function() {

		var files; // Сборщик файлов
		$('input[type=file]').change(function(){
			files = this.files;
			
			var data = new FormData();
			$.each( files, function( key, value ){
				data.append( key, value );
			});
			
			data.append( 'oper', 'send_files' );
			$.ajax({
				url: ajax_url_path,
				type        : 'POST',
				data        : data,
				cache       : false,
				dataType    : 'json',
				processData : false,
				contentType : false, 
				success     : function( respond, status, jqXHR ){
					var preview = document.querySelector('.preview');
					while(preview.firstChild) {
						preview.removeChild(preview.firstChild);
					}
						
					if(respond.files.length === 0) {
						var para = document.createElement('p');
						para.textContent = 'Не загружено не одного файла.';
						preview.appendChild(para);
					} else {
						var list = document.createElement('ol');
						preview.appendChild(list);
							
						for(var i = 0; i < respond.files.length; i++) {
							var listItem = document.createElement('li');
							listItem.textContent = 'Файл загружен: ' + respond.files[i];
							list.appendChild(listItem);
						}
					}
				}
			});
		});


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
					$(form).find ('input[type=text], input[type=hidden], textearea, select').each(function() {
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
						url: ajax_url_path,
						data: $data,
						type:'post',
						success:function(data){
							console.log(data);
							alert( `
								Запрос отправлен.
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
	});
})(jQuery);



window.isset = function(v_var) {
  if(typeof(v_var) == 'number'){ if(isNaN(v_var)){return false;}}
	if(typeof(v_var) == 'undefined' || v_var === null){return false;}
	return true;
};


(function($) {	// Работа с корзиной, beta - набросок
	'use strict';

	// Инициализация
	var timer= false;
	var cart_order= {};

	// Библиотека
	function get_count_products_in_cart(){ // Общее количество объектов вкорзине
		let countResult= 0;
		for (var order in cart_order) { // Обход корзины
			countResult += +cart_order[order].count;
		}
		return countResult;
	}

	function get_price_products_in_cart(){ // Общая стоимость объектов вкорзине
		let price= 0;
		for (var order in cart_order) { // Обход корзины
			let result= +cart_order[order].cost * +cart_order[order].count;
			price += +result;
		}
		return price;
	}

	function newModal(title,body,buttons){ // Рендер модального окна
		$('#modal .modal-title').text(title);
		$('#modal .modal-body').html(body);
		$('#modal .modal-footer').html(buttons);
		$('#modal').modal('show');
	}

	function saveCartTimer(){
		if(timer) { // Сохраним на сервере не чаще одного раза в секунду
			clearTimeout(timer);
			timer= setTimeout(saveCart,1000);
		} else {
			timer= setTimeout(saveCart,1000);
		}
	}

	function saveCart(){ // Сохраним корзину на сервере
		var data = {};
		data['cart']= JSON.stringify( cart_order ) ;
		data['oper']= 'save_cart';
		
		$.ajax({
			url: ajax_url_path,
			dataType: "json",
			data: data,
			type: "post",
			success:  function (data) {
				timer= false;
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log("save error");
			}
		});
	}

	function float2str( float ){ // Форматирует дробь в строку, добавляет символ рубль
		let result;
		if( +float - Math.floor(+float) === 0 ){
			result= +float + "-00 &#8381";
		} else {
			result= +float.toFixed(2) + " &#8381";
		}
		return result.replace('.','-');
	}


	// Обработчики
	function add_to_cart(el){ // Добавление в корзину по клику
		let id= $(el).attr('product-id');

		if(!cart_order[id]) $(el).text(`В корзине: 1`).toggleClass("btn-success btn-outline-secondary");
		else return;
		
		cart_order[id]= { 
			id: id, 
			short: $(el).attr('product-short'),
			name: $(el).attr('product-name'),
			count: 1,
			cost: extended_product[id].cost,
			balance: extended_product[id].balance,
			reserved: extended_product[id].reserved,
			url: $(el).attr('product-url')
		}

		$("#cart").text( get_count_products_in_cart() );
		saveCart();
	}

	function cartChekoutRender(){ // Корзина с формой отправки на странице заполнения платежных данных
		if( $(".cart-chekout ul").length ){
			$(this).html('');
			let ul= this;
			
			for (var order in cart_order) {
				$(ul).append(`
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">${cart_order[order].name}</h6>
								<small class="text-muted">${cart_order[order].short}</small>
							</div>
							<span class="text-muted">${cart_order[order].count}</span>
						</li>
				`);
			}
			
			$(ul).append(`
					<li class="list-group-item d-flex justify-content-between bg-light">
						<div class="text-success">
							<h6 class="my-0">Промо код</h6>
							<small>Активирован</small>
						</div>
						<span class="text-success">-5</span>
					</li>
					<li class="list-group-item d-flex justify-content-between">
						<span>Итого (РУБЛИ)</span>
						<strong>${ float2str(get_price_products_in_cart() - 5) }</strong>
					</li>
			`);
			
			$("#cart-chekout-order").val( JSON.stringify( cart_order ) );
			$(".cart-chekout .badge-pill").text( get_count_products_in_cart() );
		}
	}
	
	
	function cartPropertyRender(){ // Форма с характеристиками товара, на странице товара
		if( $(".cart-property ul").length ){
			let ul= this;
			let id= ext_product['parent_id'];
			let count= 0;
			
			if( isset(cart_order[id]) ) {
				count= +cart_order[id].count;
			} else {
				cart_order[id]= { 
					id: id, 
					short: product.short,
					name: product.meta_h1,
					count: 1,
					cost: ext_product.cost,
					balance: ext_product.balance,
					reserved: ext_product.reserved,
					url: product.friendly_url
				}
			}
			
			$(".cart-property .order-count").val( count );
			$(".cart-property .total-cost strong").html( float2str(+ext_product.cost * +count) );
						
			$(".cart-property .order-count").bind('keydown keyup change input propertychange cut copy paste',function(e){ // Расчет стоимости корзины
				let count= +$(this).val();
				let id= ext_product['parent_id'];
				let cost= +ext_product['cost'];
				
				if( !isset(cart_order[id]) ) {
					cart_order[id]= { 
						id: id, 
						short: product.short,
						name: product.meta_h1,
						count: count,
						cost: ext_product.cost,
						balance: ext_product.balance,
						reserved: ext_product.reserved,
						url: product.friendly_url
					}
				}

				if(count <= 0) {
					$(this).val(0);
					delete cart_order[id];
					count= 0;
				} else {
					cart_order[id].count= count;
				}
				
				$(".cart-property .total-cost strong").html( float2str(cost * count) );
				$("#cart").text( get_count_products_in_cart() );
				
				saveCartTimer();
			});
		}
	}

	$('#cart-link').click(function(e){ // Клик по корзине, вывод списка товаров
		e.preventDefault();
		
		if($.isEmptyObject(cart_order)) return;
		
		let count= 0;
		let countProducts= 0;
		let price= 0;
		
		let products= `
			<thead>
				<tr>
					<th>#</th>
					<th>Наименование</th>
					<th>Цена</th>
					<th>Количество</th>
					<th>Стоимость</th>
					<th></th>
				</tr>
			</thead>
		`;

		for (var order in cart_order) {
			let result= +cart_order[order].cost * +cart_order[order].count;
			price += result;
			count++
			
			countProducts += +cart_order[order].count;
			
			products +=`
				<tr prod-id="${cart_order[order].id}">
					<td>${count}</td>
					<td><a href="${cart_order[order].url}" target="_BLANC">${cart_order[order].name}</a> (<i>${cart_order[order].short}</i>)</td>
					<td>${float2str(+cart_order[order].cost)}</td>
					<td><input class="form-control order-count" type="number" value="${cart_order[order].count}"></td>
					<td>${float2str(+result)}</td>
					<td><a href="#" class="delete-item">X</a></td>
				</tr>
			`;
		}

		products += `
			<tfoot>
				<tr>
					<th></th>
					<th>ИТОГО:</th>
					<th></th>
					<th class="countProducts">${countProducts}</th>
					<th class="price">${float2str(price)}</th>
					<th></th>
				</tr>
			</tfoot>
		`;

		let body= `
			<p>Содержимое корзины:</p>
			<table class="table table-striped table-sm table-cart">${products}</table>
		`;

		let buttons= `
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
			<a class="btn btn-primary" href="/chekout.html">Оформить заказ</a>
		`;


		newModal(`Корзина`, body, buttons);
		
		// Обработчики таблицы корзины
		$( ".table-cart .delete-item" ).unbind();
		$( ".table-cart .delete-item" ).bind( "click", function(e) { // Удаление товара из корзины
			e.preventDefault();
			
			let id= $(this).closest('tr').attr("prod-id");
			$(this).closest('tr').remove();
			delete cart_order[id];
			
			$(`a[product-id=${id}]`).text(`В корзину`).toggleClass("btn-success btn-outline-secondary");
			$(".table-cart .price").html( float2str(get_price_products_in_cart()) );
			$(".table-cart .countProducts").html( get_count_products_in_cart() );
			$("#cart").text( get_count_products_in_cart() );
			
			if($.isEmptyObject(cart_order)) $(".table-cart").remove();
			
			saveCartTimer();
		});
		
		$( ".table-cart .order-count" ).unbind();
		$(".table-cart .order-count").bind('keydown keyup change input propertychange cut copy paste',function(e){ // Расчет стоимости корзины
			let count= +$(this).val();
			let id= $(this).closest('tr').attr("prod-id");
			let cost= +cart_order[id].cost;

			if(count < 1) {
				$(this).val(1);
				return;
			}
			
			if(+cart_order[id].balance - +cart_order[id].reserved < count) {
				$(this).val(cart_order[id].balance);
				return;
			}
			
			cart_order[id].count= count;
			$(this).closest('td').next().html( float2str(cost * count) );
			
			$(`a[product-id=${id}]`).text(`В корзине: ${count}`);
			$(".table-cart .price").html( float2str(get_price_products_in_cart()) );
			$(".table-cart .countProducts").html( get_count_products_in_cart() );
			$("#cart").text( get_count_products_in_cart() );
			
			if( $(".cart-property ul").length ) {// Страница товара
				$(".cart-property .total-cost strong").html( float2str(cost * count) ); 
				$(".cart-property .order-count").val( count );
			}
			
			saveCartTimer();
		});
		
		saveCartTimer();
		return false;
	});
	

	//$(document).ready(function() { 
		// Загрузка корзины, и параметров товаров, с сервера
		var data = {};
		data['oper']= 'load_cart';
		
		$.ajax({
			url: ajax_url_path,
			dataType: "json",
			data: data,
			type: "post",
			success: function (data) {
				if(data.cart != 0) {
					cart_order= data.cart;
					$("#cart").text( get_count_products_in_cart() );

					for (var order in cart_order) {
						let id= cart_order[order].id;
						
						$(`a[product-id=${id}]`).text(`В корзине: ${+cart_order[order].count}`);
						$(`a[product-id=${id}]`).toggleClass("btn-success btn-outline-secondary");
					}
					
					cartChekoutRender();
				}
				cartPropertyRender();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log("save error");
			}
		});
		
		$('.add_to_cart').click(function(el){ // Событие по кнопке добавить в корзину
			el.preventDefault();
			
			add_to_cart(this);
			return false;
		});
	//});

})(jQuery);






(function($) {	// Работа с лайками
	'use strict';

	$('.like a').click(function(e) { // Клик лайк
		e.preventDefault();

		var data = {};
		data['oper']= 'save_like';
		data['like_id']= $(this).closest('.like').attr('like-id');
		data['like_src']= likes['likesrc'];
		
		$.ajax({
			url: ajax_url_path,
			dataType: "json",
			data: data,
			type: "post",
			success:  function (data) {
				if(typeof(data.likes) != "undefined" && data.likes !== null) {
					$(`.like[like-id=${data.like_id}] span`).text(`${data.likes}`);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log("save error");
			}
		});
	});
	
	
	if(typeof(likes) != "undefined" && likes !== null) { // Загрузка лайков, с сервера
		var data = {};
		data['oper']= 'load_like';
		data['like_src']= likes['likesrc'];
		data['ids']= JSON.stringify( likes['parents'] );
		
		$.ajax({
			url: ajax_url_path,
			dataType: "json",
			data: data,
			type: "post",
			success: function (data) {
				if(typeof(data.likes) != "undefined" && data.likes !== null) {
					for (var id in data.likes) {
						$(`.like[like-id=${id}] span`).text(`${data.likes[id]}`);
					}
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log("save error");
			}
		});
	}


})(jQuery);








(function($) {	// 
	'use strict';

	// Can also be used with $(document).ready()
	$(window).load(function(){
	  $('#f1').flexslider({
		animation: "slide",
		rtl: true,
		//start: function(slider){
		  //$('body').removeClass('loading');
		//}
	  });
	 $('#f2').flexslider({
		animation: "slide",
		animationLoop: false,
		itemWidth: 210,
		itemMargin: 5,
		pausePlay: true,
		mousewheel: true,
		rtl: true,
		asNavFor:'.flexslider'
	  });
	});


})(jQuery);



/*
function num2str(n, text_forms) {  // Склонение числовых значений
	//  num2str(1, ['минута', 'минуты', 'минут']);
	n = Math.abs(n) % 100; var n1 = n % 10;
	if (n > 10 && n < 20) { return text_forms[2]; }
	if (n1 > 1 && n1 < 5) { return text_forms[1]; }
	if (n1 == 1) { return text_forms[0]; }
	return text_forms[2];
}



(function($) {
	'use strict';
	
	// Schedules the next memory measurement using setTimeout with
	// a randomized interval.
	function scheduleMeasurement() {
	  if (!performance.measureMemory) {
		console.log(
		  "performance.measureMemory() is not available. " +
			"Currently only Chrome 82+ supports it as an Origin Trial."
		);
		return;
	  }
	  const interval = measurementInterval();
	  console.log(
		"Scheduling memory measurement in " +
		  Math.round(interval / 1000) +
		  " seconds."
	  );
	  setTimeout(performMeasurement, interval);
	}

	// Start measurements after page load on the main window.
	window.onload = function() {
	  scheduleMeasurement();
	};

	// Computes a random interval in milliseconds such that on
	// average there is one measurement every five minutes.
	// See https://bit.ly/3bR0hys for an explanation of the math.
	function measurementInterval() {
	  const MEAN_INTERVAL_IN_MS = 5 * 60 * 1000;
	  return -Math.log(Math.random()) * MEAN_INTERVAL_IN_MS;
	}

	// Invokes the API, records the result, and schedules
	// the next measurement.
	async function performMeasurement() {
	  // 1. Invoke performance.measureMemory().
	  let result;
	  try {
		result = await performance.measureMemory();
	  } catch (error) {
		if (error instanceof DOMException && error.name === "SecurityError") {
		  console.log("The context is not secure.");
		  console.log(
			"Make sure that Site Isolation is enabled in Chrome " +
			  "and that the page is not embedded as an iframe."
		  );
		  return;
		}
		// Rethrow other errors.
		throw error;
	  }
	  // 2. Record the result.
	  console.log("Memory usage:", result);
	  // 3. Schedule the next measurement.
	  scheduleMeasurement();
	}
})(jQuery);
*/


