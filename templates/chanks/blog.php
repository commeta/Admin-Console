<main role="main" class="">
	
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic"><?=$meta_h1?></h1>
			<p class="lead my-3"><?=$md_meta['meta_text']?></p>
			<p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Продолжить чтение...</a></p>
		</div>
	</div>

	<div class="container">
		<div class="row">		  
			<div class="col-md-8 blog-main">
				<h3 class="pb-3 mb-4 font-italic border-bottom"><?=$md_meta['meta_title']?></h3>
<?php
foreach($blog as $post){ // Вывод анонсов постов блога
	$post_public_time= strftime_rus('%e %B2 %Y', strtotime($post['public_time']));
	echo <<<ARTICLE
	
			<div class="blog-post">
				<h2 class="blog-post-title">{$post['meta_h1']}</h2>
				<p class="blog-post-meta">$post_public_time от <a href="#">Автор</a></p>
				{$post['meta_text']}
			</div><!-- /.blog-post -->
			
ARTICLE;
}

// Вывод пагинации
print_pagination_navi($page, $totalPages)
?>

			</div><!-- /.blog-main -->
			<aside class="col-md-4 blog-sidebar">
				<div class="p-3 mb-3 bg-light rounded">
					<h4 class="font-italic">Описание</h4>
					<p class="mb-0"><em>И нет сомнений,</em> что предприниматели в сети интернет объединены в целые кластеры себе подобных.</p>
				</div>

				<div class="p-3">
					<h4 class="font-italic">Категории</h4>
					<ol class="list-unstyled mb-0">
<?php
// Вывод ссылок постов блога, по категориям
print_post_category_menu($blog_posts, $request_url);
?>

					</ol>
				</div>
			</aside><!-- /.blog-sidebar -->
		</div><!-- /.row -->
	</div>

</main>
