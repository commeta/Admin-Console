<main role="main" class="shop">
	
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic"><?=$meta_h1?></h1>
		</div>
	</div>


	<div class="container">
		<div class="row">		  
			<div class="col-md-8 blog-main">
				<h3 class="pb-3 mb-4 font-italic border-bottom"><?=$md_shop['meta_h1']?></h3>

				<!-- Place somewhere in the <body> of your page -->
				<div class="flexslider" id="f1" style="direction:rtl">
					<ul class="slides">

<?php
foreach($gallery as $v){
	if($v['img_src'] == 'data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==') 
			$v['img_src']= "holder.js/722x504?theme=thumb&bg=55595c&fg=eceeef&text={$v['img_alt']}";
	echo <<<SHOP
	
						<li>
							<img src="{$v['img_src']}"/>
							<p class="flex-caption">{$v['img_alt']}</p>
						</li>
	
SHOP;
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
	echo <<<SHOP
	
						<li><img src="{$v['img_src']}" /></li>
	
SHOP;
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
// Вывод ссылок категорий
$category= [];
foreach($shop as $v){
	if( !in_array($v['category'],$category) ) {
		$category[]= $v['category'];
		echo <<<SHOP
	
						<li><a href="#">{$v['category']}</a></li>
	
SHOP;
	
	}
}
?>

					</ol>
				</div>
			</aside><!-- /.blog-sidebar -->
		</div><!-- /.row -->		
	</div>

</main>
