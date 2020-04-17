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
<?php echo $md_portfolio['meta_h1'];?>
<?php echo $md_portfolio['project'];?>
<?php echo $md_portfolio['content'];?>
<?php echo $md_portfolio['public_time'];?>
<?php echo $public_time;?> 
											
					
<?php echo $portfolio[$prev]['friendly_url'];?>
<?php echo $md_portfolio_img[$prev_img]['img_url'];?>
<?php echo $md_portfolio_img[$prev_img]['img_alt'];?>

<?php echo $portfolio[$prev]['friendly_url'];?>
<?php echo $portfolio[$prev]['meta_h1'];?>
<?php echo $portfolio[$prev]['friendly_url'];?>
<?php echo $portfolio[$prev]['meta_h1'];?>
<?php echo $portfolio[$next]['friendly_url'];?>
<?php echo $md_portfolio_img[$next_img]['img_url'];?>
<?php echo $md_portfolio_img[$next_img]['img_alt'];?>
<?php echo $portfolio[$next]['friendly_url'];?>
<?php echo $portfolio[$next]['meta_h1'];?>
<?php echo $portfolio[$next]['friendly_url'];?>
<?php echo $portfolio[$next]['meta_h1'];?>
-->

</main>
