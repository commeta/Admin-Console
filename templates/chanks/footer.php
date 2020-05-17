<!-- FOOTER -->
<footer class="footer">
	<div class="container">
		<p class="float-right"><a href="#">Вверх</a></p>
		<p>&copy; 2019-2020 <a href="https://github.com/commeta/admin-console">Admin Console</a> &middot; </p>
		<div id="trace"></div>
	</div>
</footer>


<div id="modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p>Modal body text goes here.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>


<?php
// массив с путями до js файлов
$js_array = array(
	'js/jquery.min.js',
	'js/jquery-migrate.min.js',
	'js/popper.min.js',
	'js/holder.min.js',
	'js/bootstrap.min.js',
	'js/jquery.fancybox.min.js',
	'js/isotope.pkgd.min.js',
	'js/jquery.flexslider-min.js',
	'js/jquery.datetimepicker.js',
	'js/jquery.mask.min.js',
	'js/init.js',
);
// вызываем функцию сжатия
compression_js_files($js_array, "js/dyn/dynamic-footer.js", true);

print_server_stat("trace",$time_start,$memory); // Вывод статистки сервера
?>

	</body>
</html>
