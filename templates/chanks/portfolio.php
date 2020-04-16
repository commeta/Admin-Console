<?php
$db->orderBy("public_time","Desc");
$md_portfolio= $db->get('md_portfolio', null, ['id','friendly_url','meta_h1','short','project']);

$parents = array_column($md_portfolio, 'id');

/*
$db->where('parent_id', $parents, 'in');
$db->where('img_size', '800x600');
$img_preview= $db->map('parent_id')->ArrayBuilder()->get('md_portfolio_img', null, ['parent_id','img_url','img_alt']);

$db->where('parent_id', $parents, 'in');
$db->where('img_size', 'gallery');
$db->orderBy("img_url","DESC");
$img_screenshot= $db->map('parent_id')->ArrayBuilder()->get('md_portfolio_img', null, ['parent_id','img_url','img_alt']);
*/

$db->where('parent_id', $parents, 'in');
$db->where("(img_size = ? or img_size = ?)", ['gallery','']);
$images= $db->get('md_portfolio_img');

$img_screenshot= []; 
$img_preview= [];

foreach($images as $v){
	if($v['img_size'] == 'gallery') $img_screenshot[$v['parent_id']]= $v;
	if($v['img_size'] == '800x600') $img_preview[$v['parent_id']]= $v;
}

$category= [];
foreach($md_portfolio as $v){
	if( !in_array($v['project'],$category) ) $category[]= $v['project'];
}
?>

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
foreach($category as $v){
	printf('<li><a href="" class="btn" data-filter=".filter%s">%s</a></li>',array_search($v,$category),$v);
}
?>														
	</ul>              
	<div class="row works clearfix">
<?php
foreach($md_portfolio as $v){
	$idFilter= array_search($v['project'],$category);

	if($img_screenshot[$v['id']]['img_url'] == '') $img_screenshot[$v['id']]['img_url'] = "holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text={$v['meta_h1']}";
	
	echo <<<PORTFOLIO
		<div class="col-md-4 work filter$idFilter">
			<div class="card mb-4 shadow-sm">
				<img class="card-img-top" data-src="{$img_screenshot[$v['id']]['img_url']}" alt="{$img_screenshot[$v['id']]['img_alt']}" width="100" height="225">
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


