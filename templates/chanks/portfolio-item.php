<main role="main" class="portfolio">
	
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic"><?=$meta_h1?></h1>
		</div>
	</div>


	<div class="container">
		<div class="row">		  
			<div class="col-md-8 blog-main">
				<h3 class="pb-3 mb-4 font-italic border-bottom"><?=$md_portfolio['meta_h1']?></h3>

				<!-- Place somewhere in the <body> of your page -->
				<div class="flexslider" id="f1" style="direction:rtl">
					<ul class="slides">

<?php
foreach($gallery as $v){
	if($v['img_src'] == 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==') 
			$v['img_src']= "holder.js/722x504?theme=thumb&bg=55595c&fg=eceeef&text={$v['img_alt']}";
	echo <<<PORTFOLIO
	
						<li>
							<img src="{$v['img_src']}"/>
							<p class="flex-caption">{$v['img_alt']}</p>
						</li>
	
PORTFOLIO;
}
?>

					</ul>
				</div>
				<div class="flexslider carousel" id="f2" style="direction:rtl">
					<ul class="slides">
<?php
foreach($gallery as $v){
	if($v['img_src'] == 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==') 
			$v['img_src']= "holder.js/205x125?theme=thumb&bg=55595c&fg=eceeef&text={$v['img_alt']}";
	echo <<<PORTFOLIO
	
						<li><img src="{$v['img_src']}" /></li>
	
PORTFOLIO;
}
?>			

					</ul>
				</div>
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
// Вывод ссылок постов, по категориям
print_post_category_menu($portfolio, $request_url);
?>

					</ol>
				</div>
			</aside><!-- /.blog-sidebar -->
		</div><!-- /.row -->
		
		
		<hr />
		<div class="row mb-2">
			<div class="col-md-6">
				<div class="card flex-md-row mb-4 shadow-sm h-md-250">
					<div class="card-body d-flex flex-column align-items-start">
						<strong class="d-inline-block mb-2 text-primary"><?=$portfolio[$prev]['category']?></strong>
						<h3 class="mb-0"><a class="text-dark" href="<?=$portfolio[$prev]['friendly_url']?>"><?=$portfolio[$prev]['meta_h1']?></a></h3>
						<div class="mb-1 text-muted"><?=strftime_rus('%e %B2 %Y',strtotime($portfolio[$prev]['public_time']))?></div>
						<p class="card-text mb-auto"><?=$portfolio[$prev]['meta_title']?></p>
						<a href="<?=$portfolio[$prev]['friendly_url']?>">Продолжить чтение</a>
					</div>
					<img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
				</div>
			</div>
			<div class="col-md-6">
				<div class="card flex-md-row mb-4 shadow-sm h-md-250">
					<div class="card-body d-flex flex-column align-items-start">
						<strong class="d-inline-block mb-2 text-success"><?=$portfolio[$next]['category']?></strong>
						<h3 class="mb-0"><a class="text-dark" href="<?=$portfolio[$next]['friendly_url']?>"><?=$portfolio[$next]['meta_h1']?></a></h3>
						<div class="mb-1 text-muted"><?=strftime_rus('%e %B2 %Y',strtotime($portfolio[$next]['public_time']))?></div>
						<p class="card-text mb-auto"><?=$portfolio[$next]['meta_title']?></p>
						<a href="<?=$portfolio[$next]['friendly_url']?>">Продолжить чтение</a>
					</div>
					<img class="card-img-right flex-auto d-none d-lg-block" data-src="holder.js/200x250?theme=thumb" alt="Card image cap">
				</div>
			</div>
		</div>
		
	</div>


</main>
