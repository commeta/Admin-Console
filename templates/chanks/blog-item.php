<?php
// Запрос списка страниц
$db->orderBy("public_time","Desc");
$blog_posts= $db->get('md_blog', null, ['id','friendly_url','meta_h1','category']);

// Предыдущая/Следующая
$current= array_search($md_blog['id'], array_column($blog_posts, 'id'));
$count_blog= count($blog_posts);

if($current > 0) $prev= $current - 1;
else $prev= $count_blog - 1;

if($current < $count_blog - 1) $next= $current + 1;
else $next= 0;

// Запрос страниц Предыдущая\Следующая
$db->where('id', [$blog_posts[$prev]['id'],$blog_posts[$next]['id']], 'in');
$blog= $db->get('md_blog', null, ['id','friendly_url','meta_title','meta_h1','image','public_time','category','meta_text']);

$prev= 0;
$next= 1;
?>
<main role="main" class="">
	
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic"><?=$meta_h1?></h1>
		</div>
	</div>

    
	<div class="container">
		
		<div class="row mb-2">
			<div class="col-md-6">
				<div class="card flex-md-row mb-4 shadow-sm h-md-250">
					<div class="card-body d-flex flex-column align-items-start">
						<strong class="d-inline-block mb-2 text-primary"><?=$blog[$prev]['category']?></strong>
						<h3 class="mb-0"><a class="text-dark" href="<?=$blog[$prev]['friendly_url']?>"><?=$blog[$prev]['meta_h1']?></a></h3>
						<div class="mb-1 text-muted"><?=strftime('%B %Y',strtotime($blog[$prev]['public_time']))?></div>
						<p class="card-text mb-auto"><?=$blog[$prev]['meta_title']?></p>
						<a href="<?=$blog[$prev]['friendly_url']?>">Продолжить чтение</a>
					</div>
					<img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
				</div>
			</div>
			<div class="col-md-6">
				<div class="card flex-md-row mb-4 shadow-sm h-md-250">
					<div class="card-body d-flex flex-column align-items-start">
						<strong class="d-inline-block mb-2 text-success"><?=$blog[$next]['category']?></strong>
						<h3 class="mb-0"><a class="text-dark" href="<?=$blog[$next]['friendly_url']?>"><?=$blog[$next]['meta_h1']?></a></h3>
						<div class="mb-1 text-muted"><?=strftime('%B %Y',strtotime($blog[$next]['public_time']))?></div>
						<p class="card-text mb-auto"><?=$blog[$next]['meta_title']?></p>
						<a href="<?=$blog[$next]['friendly_url']?>">Продолжить чтение</a>
					</div>
					<img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
				</div>
			</div>
		</div>
	
	
		<div class="row">		  
			<div class="col-md-8 blog-main">
				<h3 class="pb-3 mb-4 font-italic border-bottom"><?=$md_blog['meta_h1']?></h3>
				<?=$md_blog['content']?>
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
