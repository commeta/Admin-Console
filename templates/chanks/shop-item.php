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

				<!-- Place somewhere in the <slider> of your page -->
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
			</div><!-- /.shop-main -->

			<aside class="col-md-4 blog-sidebar">
				
				<div class="p-3 mb-3 bg-light rounded">
					<h4 class="font-italic">Описание</h4>
					<p class="mb-0"><em>И нет сомнений,</em> что предприниматели в сети интернет объединены в целые кластеры себе подобных.</p>
				</div>
			
				<div class="p-3 mb-3 bg-light rounded cart-property">
					<h4 class="d-flex justify-content-between align-items-center mb-3">
						<span class="text-muted">Характеристики товара</span>
					</h4>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Высота</h6>
								<small class="text-muted">в сантиметрах</small>
							</div>
							<span class="text-muted"><?=$md_shop_extended_product['product_heidht']?></span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Ширина</h6>
								<small class="text-muted">в сантиметрах</small>
							</div>
							<span class="text-muted"><?=$md_shop_extended_product['product_width']?></span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Вес</h6>
								<small class="text-muted">в граммах</small>
							</div>
							<span class="text-muted"><?=$md_shop_extended_product['product_weight']?></span>
						</li>
						<li class="list-group-item d-flex justify-content-between lh-condensed">
							<div>
								<h6 class="my-0">Количество</h6>
								<small class="text-muted">штук</small>
							</div>
							<input class="form-control order-count" type="number" value="0">
						</li>
						<li class="list-group-item d-flex justify-content-between total-cost">
							<span><b>Итого:</b></span>
							<strong >00-00 &#8381 </strong>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<a class="btn btn-primary btn-lg btn-block" href="/chekout.html">Оформить заказ</a>
						</li>
					</ul>
				</div>
								

				<div class="p-3 mb-3 bg-light rounded">
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

<script>
var ext_product= JSON.parse(`<?=json_encode($md_shop_extended_product)?>`);
var product= JSON.parse(`<?=json_encode($md_shop)?>`);
</script>
