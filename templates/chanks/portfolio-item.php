<main role="main" class="">
	<section class="jumbotron text-center bg-light">
		<div class="container">
			<h1 class="jumbotron-heading"><?=$meta_h1?></h1>
			<p class="lead text-muted"><?=$md_portfolio['description']?></p>
		</div>
	</section>

<?php
foreach($screenshot as $v){
	//$v['img_alt'], $v['img_url']
}

?>			



	<div class="container text-center my-3">
		<h3><?=$md_portfolio['meta_title']?></h3>
		<div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
			<div class="carousel-inner w-100" role="listbox">
				<div class="carousel-item row no-gutters active">
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=222&fg=fff&text=1"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=444&fg=eceeef&text=2"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=888&fg=eceeef&text=3"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=111&fg=fff&text=4"></div>
				</div>
				<div class="carousel-item row no-gutters">
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&text=5"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=555&text=6"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=333&fg=fff&text=7"></div>
					<div class="col-3 float-left"><img class="img-fluid" src="holder.js/350x280?theme=thumb&bg=bbb&text=8"></div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Предыдущий</span> </a>
			<a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Следующий</span> </a>
		</div>
	</div>

<!--						
<?=$md_portfolio['meta_h1']?>
<?=$md_portfolio['project']?>
<?=$md_portfolio['content']?>
<?=$md_portfolio['public_time']?>
<?=$public_time?> 
											
					
<?=$portfolio[$prev]['friendly_url']?>
<?=$md_portfolio_img[$prev_img]['img_url']?>
<?=$md_portfolio_img[$prev_img]['img_alt']?>
<?=$portfolio[$prev]['friendly_url']?>
<?=$portfolio[$prev]['meta_h1']?>
<?=$portfolio[$prev]['friendly_url']?>
<?=$portfolio[$prev]['meta_h1']?>
<?=$portfolio[$next]['friendly_url']?>
<?=$md_portfolio_img[$next_img]['img_url']?>
<?=$md_portfolio_img[$next_img]['img_alt']?>
<?=$portfolio[$next]['friendly_url']?>
<?=$portfolio[$next]['meta_h1']?>
<?=$portfolio[$next]['friendly_url']?>
<?=$portfolio[$next]['meta_h1']?>
-->

</main>
