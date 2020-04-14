<?php
// Если есть то отдаем из кэша страницу, и обработаем заголовок if modified since
if($cached_page = get_cached_page( $urlMd5 )){
	ifMofifiedSince( $urlMd5 );
	die($cached_page);
}

require_once('chanks/header.php');
?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-item active"> <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
			<div class="container">
				<div class="carousel-caption text-left">
					<h1>Пример заголовка.</h1>
					<p>Безусловно, понимание сути ресурсосберегающих технологий однозначно определяет каждого участника как способного принимать собственные решения касаемо приоритизации разума над эмоциями.</p>
					<p><a class="btn btn-lg btn-primary" href="#" role="button">Подписка</a></p>
				</div>
			</div>
		</div>
		<div class="carousel-item"> <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
			<div class="container">
				<div class="carousel-caption">
					<h1>Другой пример заголовка.</h1>
					<p>Безусловно, понимание сути ресурсосберегающих технологий однозначно определяет каждого участника как способного принимать собственные решения касаемо приоритизации разума над эмоциями.</p>
					<p><a class="btn btn-lg btn-primary" href="#" role="button">Далее</a></p>
				</div>
			</div>
		</div>
		<div class="carousel-item"> <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
			<div class="container">
				<div class="carousel-caption text-right">
					<h1>Один из примеров заголовка.</h1>
					<p>Безусловно, понимание сути ресурсосберегающих технологий однозначно определяет каждого участника как способного принимать собственные решения касаемо приоритизации разума над эмоциями.</p>
					<p><a class="btn btn-lg btn-primary" href="#" role="button">Галерея</a></p>
				</div>
			</div>
		</div>
	</div>
	<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Предыдущий</span> </a>
	<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Следующий</span> </a>
</div>
<!-- Marketing messaging and featurettes
      ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<div class="container marketing">
	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="col-lg-4"> <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
			<h2>Заголовок</h2>
			<p>Каждый из нас понимает очевидную вещь: курс на социально-ориентированный национальный проект в значительной степени обусловливает важность дальнейших направлений развития.</p>
			<p><a class="btn btn-secondary" href="#" role="button">Подробнее &raquo;</a></p>
		</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-4"> <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
			<h2>Заголовок</h2>
			<p>Противоположная точка зрения подразумевает, что интерактивные прототипы представляют собой не что иное, как квинтэссенцию победы маркетинга над разумом и должны быть ограничены.</p>
			<p><a class="btn btn-secondary" href="#" role="button">Подробнее &raquo;</a></p>
		</div>
		<!-- /.col-lg-4 -->
		<div class="col-lg-4"> <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
			<h2>Заголовок</h2>
			<p>Противоположная точка зрения подразумевает, что активно развивающиеся страны третьего мира и по сей день остаются уделом либералов, которые жаждут быть превращены в посмешище.</p>
			<p><a class="btn btn-secondary" href="#" role="button">Подробнее &raquo;</a></p>
		</div>
		<!-- /.col-lg-4 -->
	</div>
	<!-- /.row -->
	<!-- START THE FEATURETTES -->
	<hr class="featurette-divider">
	<div class="row featurette">
		<div class="col-md-7">
			<h2 class="featurette-heading">Первый заголовок.</h2>
			<p class="lead">Являясь всего лишь частью общей картины, сделанные на базе интернет-аналитики выводы являются только методом политического участия и ограничены исключительно образом мышления.</p>
		</div>
		<div class="col-md-5"> <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image"> </div>
	</div>
	<hr class="featurette-divider">
	<div class="row featurette">
		<div class="col-md-7 order-md-2">
			<h2 class="featurette-heading">Второй заголовок.</h2>
			<p class="lead">Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: постоянное информационно-пропагандистское обеспечение нашей деятельности обеспечивает широкому кругу (специалистов) участие в формировании инновационных методов управления процессами.</p>
		</div>
		<div class="col-md-5 order-md-1"> <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image"> </div>
	</div>
	<hr class="featurette-divider">
	<div class="row featurette">
		<div class="col-md-7">
			<h2 class="featurette-heading">Последний заголовок.</h2>
			<p class="lead">Мы вынуждены отталкиваться от того, что постоянный количественный рост и сфера нашей активности однозначно определяет каждого участника как способного принимать собственные решения касаемо направлений прогрессивного развития.</p>
		</div>
		<div class="col-md-5"> <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image"> </div>
	</div>
	<hr class="featurette-divider">
	<!-- /END THE FEATURETTES -->
</div>
<!-- /.container -->


<?php
require_once('chanks/footer.php');
set_cached_page($urlMd5); // Сохраним страницу в кэше
?>
