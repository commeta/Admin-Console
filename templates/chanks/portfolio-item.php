<main role="main" class="">
		
<?php
foreach($screenshot as $v){
	printf('<div class="mkdf-portfolio-single-media"><a itemprop="url" title="%s" data-rel="prettyPhoto[single_pretty_photo]" href="%s"><img itemprop="image" src="%s" alt="%s" /></a></div>',
		$v['img_alt'], $v['img_url'], $v['img_url'], $v['img_alt']
	);
}

foreach($screenshot_mobile as $v){
	printf('<div class="mkdf-portfolio-single-media"><img itemprop="image" src="%s" alt="%s" /></div>',
		$v['img_url'], $v['img_alt']
	);
}
?>			


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
