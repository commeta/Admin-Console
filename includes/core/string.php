<?php

// Работает точно так же, как и strftime(),
// только в строке формата может принимать
// дополнительный аргумент %B2, который будет заменен
// на русское название месяца в родительном падеже.
   
// В остальном правила для $format такие же, как и для strftime().
// (в связи с этим рекомендуется настроить выполнение скрипта
// с помощью setlocale: http://php.net/setlocale)
   
// Второй аргумент можно передавать как в виде временной метки
// так и в виде строки типа 2010-05-16 23:48:20
// функция сама определит, в каком виде передана дата,
// и проведет преобразование.
// Если второй аргумент не указан,
// функция будет работать с текущим временем.
function strftime_rus($format, $date = FALSE) {
	if (!$date) $timestamp = time();
	elseif (!is_numeric($date)) $timestamp = strtotime($date);
	else $timestamp = $date;
	   
	if (strpos($format, '%B2') === FALSE) return strftime($format, $timestamp);
	$month_number = date('n', $timestamp);
	   
	switch ($month_number) {
		case 1: $rus = 'Января'; break;
		case 2: $rus = 'Февраля'; break;
		case 3: $rus = 'Марта'; break;
		case 4: $rus = 'Апреля'; break;
		case 5: $rus = 'Мая'; break;
		case 6: $rus = 'Июня'; break;
		case 7: $rus = 'Июля'; break;
		case 8: $rus = 'Августа'; break;
		case 9: $rus = 'Сентября'; break;
		case 10: $rus = 'Октября'; break;
		case 11: $rus = 'Ноября'; break;
		case 12: $rus = 'Декабря'; break;
	}

	$rusformat = str_replace('%B2', $rus, $format);
	return strftime($rusformat, $timestamp);
}

?>
