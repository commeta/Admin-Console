<main role="main" class="">
	
	<section class="jumbotron text-center bg-light">
		<div class="container">
			<h1 class="jumbotron-heading"><?=$meta_h1?></h1>
			<p class="lead text-muted"><?=$md_meta['meta_text']?></p>
		</div>
	</section>


	<div class="album py-5">
		<div class="container">
			<ul id="filter" class="clearfix pb-5">
				<li><a href="" class="current btn" data-filter="*">Все</a></li>
<?php
foreach($category as $v){ // Вывод фильтра
	printf('<li><a href="" class="btn" data-filter=".filter%s">%s</a></li>',array_search($v,$category),$v);
}
?>														
			</ul>              
			<div class="row works clearfix">
<?php
foreach($md_portfolio as $v){ // Вывод карточек
	$idFilter= array_search($v['project'],$category);

	if($img_screenshot[$v['id']]['img_url'] == '') $img_screenshot[$v['id']]['img_url'] = "holder.js/348x225?theme=thumb&bg=55595c&fg=eceeef&text={$v['meta_h1']}";
		
	echo <<<PORTFOLIO
	
				<div class="col-md-4 work filter$idFilter">
					<div class="card mb-4 shadow-sm">
						<img class="card-img-top" data-src="{$img_screenshot[$v['id']]['img_url']}" alt="{$img_screenshot[$v['id']]['img_alt']}" width="348" height="225">
						<div class="card-body">
							<p class="card-text">{$v['short']}</p>
							<div class="d-flex justify-content-between align-items-center">
								<div class="btn-group">
									<a class="btn btn-sm btn-outline-secondary" href="{$v['friendly_url']}">Просмотр</a>
								</div>
								<small class="text-muted">9 mins</small>
							</div>
						</div>
					</div>
				</div>
				
PORTFOLIO;
}
?>

			</div>
		</div>
	</div>

</main>
