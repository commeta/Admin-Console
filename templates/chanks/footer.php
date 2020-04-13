	</main>
    <!-- FOOTER -->
    <footer class="footer">
      <div class="container">
		  <p class="float-right"><a href="#">Back to top</a></p>
		  <p>&copy; 2017-2018 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
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
?>



  </body>
</html>
