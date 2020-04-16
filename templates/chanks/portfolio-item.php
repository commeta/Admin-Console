<?php
// Изображения
$db->where('parent_id', $md_portfolio['id'] );
$md_portfolio_img= $db->get('md_portfolio_img');

$screenshot = array_filter($md_portfolio_img, function($k) {
    return $k['img_size'] == 'screenshot';
});
$screenshot_mobile = array_filter($md_portfolio_img, function($k) {
    return $k['img_size'] == 'screenshot-mobile';
});


// Навигация Влево - Вправо
$db->orderBy("public_time","Desc");
$portfolio= $db->get('md_portfolio', null, ['id','friendly_url','meta_h1']);

$current= array_search($md_portfolio['id'], array_column($portfolio, 'id'));
$count_portfolio= count($portfolio);

if($current > 0) $prev= $current - 1;
else $prev= $count_portfolio - 1;

if($current < $count_portfolio - 1) $next= $current + 1;
else $next= 0;

$db->where("(parent_id = ? or parent_id = ?)", Array($portfolio[$prev]['id'],$portfolio[$next]['id']));
$db->where("img_size","150x150");
$md_portfolio_img= $db->get("md_portfolio_img");

$prev_img= array_search($portfolio[$prev]['id'], array_column($md_portfolio_img, 'parent_id'));
$next_img= array_search($portfolio[$next]['id'], array_column($md_portfolio_img, 'parent_id'));

// Дата
$public_time= strftime('%B, %Y',strtotime($md_portfolio['public_time']));
?>


		
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
										<div itemprop="headline" class="h5 mkdf-portfolio-item-title"><?php echo $md_portfolio['meta_h1'];?></div>
										<div class="mkdf-portfolio-item-categories">
											<div class="h6"><?php echo $md_portfolio['project'];?></div> 
										</div>
										<div itemprop="description" class="mkdf-portfolio-item-content">
											<p><?php echo $md_portfolio['content'];?></p>
										</div>
									</div>
									<div class="mkdf-portfolio-info-item mkdf-portfolio-date">
										<div class="h6">Дата</div>
										<p>
											<time itemprop="datePublished" datetime="<?php echo $md_portfolio['public_time'];?>"> <?php echo $public_time;?> </time>
										</p>
									</div>
									



					
					
					
						<div class="mkdf-portfolio-prev mkdf-single-nav-with-image">
							<div class="mkdf-single-nav-image-holder">
								<a href="<?php echo $portfolio[$prev]['friendly_url'];?>"> 
									<img width="150" height="150" src="<?php echo $md_portfolio_img[$prev_img]['img_url'];?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="<?php echo $md_portfolio_img[$prev_img]['img_alt'];?>" /> 
								</a>
							</div>
							<div class="mkdf-single-nav-content-holder">
								<div class="h6"><a href="<?php echo $portfolio[$prev]['friendly_url'];?>"><?php echo $portfolio[$prev]['meta_h1'];?></a></div>
								<a class="mkdf-single-nav-label-holder" href="<?php echo $portfolio[$prev]['friendly_url'];?>" title="<?php echo $portfolio[$prev]['meta_h1'];?>"> 
									<span class="mkdf-single-nav-arrow">
										<span aria-hidden="true" class="mkdf-icon-font-elegant arrow_carrot-left_alt2 "></span> 
									</span> 
									<span class="mkdf-single-nav-label">Предыдущий</span> 
								</a>
							</div>
						</div>
						<div class="mkdf-portfolio-back-btn">
							<a href="/portfolio/"> <span class="fa fa-th-large"></span> </a>
						</div>
						<div class="mkdf-portfolio-next mkdf-single-nav-with-image">
							<div class="mkdf-single-nav-image-holder">
								<a href="<?php echo $portfolio[$next]['friendly_url'];?>"> 
									<img width="150" height="150" src="<?php echo $md_portfolio_img[$next_img]['img_url'];?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="<?php echo $md_portfolio_img[$next_img]['img_alt'];?>" /> 
								</a>
							</div>
							<div class="mkdf-single-nav-content-holder">
								<div class="h6"><a href="<?php echo $portfolio[$next]['friendly_url'];?>"><?php echo $portfolio[$next]['meta_h1'];?></a></div>
								<a class="mkdf-single-nav-label-holder" href="<?php echo $portfolio[$next]['friendly_url'];?>" title="<?php echo $portfolio[$next]['meta_h1'];?>"> 
									<span class="mkdf-single-nav-label">Следующий</span> 
									<span class="mkdf-single-nav-arrow">
										<span aria-hidden="true" class="mkdf-icon-font-elegant arrow_carrot-right_alt2 "></span> 
									</span>
								</a>
							</div>
						</div>
-->
