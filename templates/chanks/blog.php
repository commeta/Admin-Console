<?php
$db->orderBy("public_time","Desc"); // Список постов для меню в сайдбаре
$blog_posts= $db->get('md_blog', null, ['friendly_url','meta_h1','category']);

// Категории
$category= [];
foreach($blog_posts as $v){
	if( !in_array($v['category'],$category) ) $category[]= $v['category'];
}
?>
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
	$post_public_time= strftime('%e %B %Y',strtotime($post['public_time']));
	echo <<<ARTICLE
			<div class="blog-post">
				<h2 class="blog-post-title">{$post['meta_h1']}</h2>
				<p class="blog-post-meta">$post_public_time от <a href="#">Автор</a></p>
				{$post['meta_text']}
			</div><!-- /.blog-post -->
ARTICLE;
}


// Вывод пагинации
echo '<nav aria-label="Блог">';
echo '<ul class="pagination justify-content-center">';

if( $page <= 1 ) echo '<li class="page-item disabled"><span class="page-link">Предыдущая</span></li>';
else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">Предыдущая</a></li>',$page - 1);

for( $i=1; $i<=$totalPages; $i++){
	if($i == $page) printf('<li class="page-item active"><span class="page-link">%d<span class="sr-only">(текущая)</span></span></li>',$i);
	else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">%d</a></li>',$i,$i);
}

if( $totalPages < $page + 1 ) echo '<li class="page-item disabled"><span class="page-link">Следующая</span></li>';
else printf('<li class="page-item"><a class="page-link" href="/blog/%d/">Следующая</a></li>',$page + 1);

echo '</ul>';
echo '</nav>';
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
foreach($category as $cat){ // Вывод ссылок постов блога, по категориям
	$sub_cat= '';
	$current= false;
	
	foreach($blog_posts as $post){
		if($post['category'] == $cat){
			if($request_url['path'] == $post['friendly_url']){
				$current= true;
				$sub_cat .= sprintf('<li class="current-menu"><a href="%s">%s</a></li>',$post['friendly_url'],$post['meta_h1']);
			} else {
				$sub_cat .= sprintf('<li><a href="%s">%s</a></li>',$post['friendly_url'],$post['meta_h1']);
			}
		}
	}
	
	if( $sub_cat != '' ){
		if($current) 
			printf('<li class="children"><a href="#">%s</a><ul class="sub-menu">%s</ul></li>',
				$cat,$sub_cat
			);
		else 
			printf('<li class="children"><a href="#">%s</a><ul class="sub-menu">%s</ul></li>',
				$cat,$sub_cat
			);
	}
}
?>
					</ol>
				</div>
			</aside><!-- /.blog-sidebar -->
		</div><!-- /.row -->
	</div>

</main>
