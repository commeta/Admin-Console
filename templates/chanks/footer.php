	</main>
	
    <!-- FOOTER -->
    <footer class="footer">
      <div class="container">
		  <p class="float-right"><a href="#">Вверх</a></p>
		  <p>&copy; 2019-2020 <a href="https://github.com/commeta/admin-console">Admin Console</a> &middot; </p>
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
	'js/jquery.fancybox.min.js',
	'js/isotope.pkgd.min.js',
	'js/init.js'
);
// вызываем функцию сжатия
compression_js_files($js_array, "js/dyn/dynamic-footer.js", true);

print_server_stat("trace",$time_start,$memory); // Вывод статистки сервера
?>
  </body>
</html>
