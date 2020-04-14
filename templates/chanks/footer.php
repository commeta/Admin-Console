	</main>
	
    <!-- FOOTER -->
    <footer class="footer">
      <div class="container">
		  <p class="float-right"><a href="#">Вверх</a></p>
		  <p>&copy; 2019-2020 <a href="https://webdevops.ru/admin-console.html">WebDevOps</a> &middot; </p>
		  <div id="trace"></div>
      </div>
    </footer>

<?php
// массив с путями до js файлов
$js_array = array(
	'js/jquery.min.js',
	'js/popper.min.js',
	'js/holder.min.js',
	'js/bootstrap.min.js',
	'js/init.js'
);
// вызываем функцию сжатия
compression_js_files($js_array, "js/dyn/dynamic-footer.js", true);

$db_trace= $db->trace;
$db_time= 0;
$db_count= 0;

foreach($db_trace as $v){
	$db_time= $db_time + $v[1];
	$db_count++;
}

$time_end = microtime(1);
$time = $time_end - $time_start; 

printf('<script>document.getElementById("trace").innerHTML= "Страница была сгенерирована за %s сек. Выполнено %s запросов к БД за %s сек.";</script>',round($time,5),$db_count,round($db_time,5));
?>
  </body>
</html>
