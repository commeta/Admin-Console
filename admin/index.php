<?php
require_once('includes.php');
$profile= $_SESSION['md_users'];


#######################################################################
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin Console</title>
		<meta name="description" content="description">
		<meta name="author" content="DevOOPS">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
		<link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
		<!--<link href="plugins/select2/select2.css" rel="stylesheet">-->
		<link href="plugins/select2_4/select2.min.css" rel="stylesheet">
		<link href="plugins/justified-gallery/justifiedGallery.css" rel="stylesheet">
		<link href="css/style_v1.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="plugins/chartist/chartist.min.css" rel="stylesheet">
		<link href="plugins/BootSideMenu/css/BootSideMenu.css" rel="stylesheet">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
<!--Start Header-->
<div id="screensaver">
	<canvas id="canvas"></canvas>
	<i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
	<div class="devoops-modal">
		<div class="devoops-modal-header">
			<div class="modal-header-name">
				<span>Basic table</span>
			</div>
			<div class="box-icons">
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="devoops-modal-inner">
		</div>
		<div class="devoops-modal-bottom">
		</div>
	</div>
</div>
<header class="navbar">
	<div class="container-fluid expanded-panel">
		<div class="row">
			<div id="logo" class="col-xs-12 col-sm-2">
				<a href="/admin/">Admin Console</a>
			</div>
			<div id="top-panel" class="col-xs-12 col-sm-10">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						<!--<div id="search">
							<input type="text" placeholder="Поиск"/>
							<i class="fa fa-search"></i>
						</div>-->
					</div>
					<div class="col-xs-4 col-sm-8 top-panel-right">
						<ul class="nav navbar-nav pull-right panel-menu">
							<li class="hidden-xs">
								<a class="modal-link ol-link">
									<i class="fa fa-info"></i>
								</a>
							</li>
							<li class="hidden-xs">
								<a class="ajax-link" href="ajax/calendar.html">
									<i class="fa fa-calendar"></i>
									<!--<span class="badge">0</span>-->
								</a>
							</li>
							<li class="hidden-xs">
								<a href="ajax/page_messages.html" class="ajax-link">
									<i class="fa fa-envelope"></i>
									<!--<span class="badge">0</span>-->
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
									<div class="avatar">
										<img src="/admin/img/photo-10.jpg" photo_url="<?php echo $profile['photo_url']; ?>" class="img-circle" alt="avatar" />
									</div>
									<i class="fa fa-angle-down pull-right"></i>
									<div class="user-mini pull-right">
										<span class="welcome">Добро пожаловать,</span>
										<span><?php echo $profile['name']; ?></span>
									</div>
								</a>
								<ul class="dropdown-menu">
									<!--
									<li>
										<a href="functions/profile.php" class="ajax-link">
											<i class="fa fa-user"></i>
											<span>Профиль</span>
										</a>
									</li>
									-->
									<li>
										<a href="ajax/page_messages.html" class="ajax-link">
											<i class="fa fa-envelope"></i>
											<span>Сообщения</span>
										</a>
									</li>
									<li>
										<a href="ajax/gallery_simple.html" class="ajax-link">
											<i class="fa fa-picture-o"></i>
											<span>Альбом</span>
										</a>
									</li>
									<li>
										<a href="ajax/calendar.html" class="ajax-link">
											<i class="fa fa-tasks"></i>
											<span>Задачи</span>
										</a>
									</li>
									<li>
										<a href="functions/profile.php"  class="ajax-link">
											<i class="fa fa-cog"></i>
											<span>Настройки</span>
										</a>
									</li>
									<li>
										<a href="/admin/logout.php">
											<i class="fa fa-power-off"></i>
											<span>Выход</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				
				<!--
				<li>
					<a href="ajax/dashboard.html" class="ajax-link">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs">Дашборд</span>
					</a>
				</li>
				-->
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-hospital-o"></i>
						
						<span class="hidden-xs">Управление сайтом</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="functions/friendly.php">Главные разделы</a></li>
						<li><a class="ajax-link" href="functions/images-editor.php">Редактор изображений</a></li>
						<li><a class="ajax-link" href="functions/messages-commander.php">Модерация сообщений</a></li>
						
						
						<!--
						<li><a class="ajax-link" href="functions/main_menu.php">Главное меню</a></li>
						-->
					</ul>
				</li>
				
				
				
				
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-list"></i>
						<span class="hidden-xs">Примеры страниц</span>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-bar-chart-o"></i>
								<span class="hidden-xs">Charts</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/charts_xcharts.html">xCharts</a></li>
								<li><a class="ajax-link" href="ajax/charts_flot.html">Flot Charts</a></li>
								<li><a class="ajax-link" href="ajax/charts_google.html">Google Charts</a></li>
								<li><a class="ajax-link" href="ajax/charts_morris.html">Morris Charts</a></li>
								<li><a class="ajax-link" href="ajax/charts_amcharts.html">AmCharts</a></li>
								<li><a class="ajax-link" href="ajax/charts_chartist.html">Chartist</a></li>
								<li><a class="ajax-link" href="ajax/charts_coindesk.html">CoinDesk realtime</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-table"></i>
								 <span class="hidden-xs">Tables</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/tables_simple.html">Simple Tables</a></li>
								<li><a class="ajax-link" href="ajax/tables_datatables.html">Data Tables</a></li>
								<li><a class="ajax-link" href="ajax/tables_beauty.html">Beauty Tables</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-pencil-square-o"></i>
								 <span class="hidden-xs">Forms</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/forms_elements.html">Elements</a></li>
								<li><a class="ajax-link" href="ajax/forms_layouts.html">Layouts</a></li>
								<li><a class="ajax-link" href="ajax/forms_file_uploader.html">File Uploader</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-desktop"></i>
								 <span class="hidden-xs">UI Elements</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/ui_grid.html">Grid</a></li>
								<li><a class="ajax-link" href="ajax/ui_buttons.html">Buttons</a></li>
								<li><a class="ajax-link" href="ajax/ui_progressbars.html">Progress Bars</a></li>
								<li><a class="ajax-link" href="ajax/ui_jquery-ui.html">Jquery UI</a></li>
								<li><a class="ajax-link" href="ajax/ui_icons.html">Icons</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-list"></i>
								 <span class="hidden-xs">Pages</span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="ajax/page_login_v1.html">Login</a></li>
								<li><a href="ajax/page_register_v1.html">Register</a></li>
								<li><a id="locked-screen" class="submenu" href="ajax/page_locked.html">Locked Screen</a></li>
								<li><a class="ajax-link" href="ajax/page_contacts.html">Contacts</a></li>
								<li><a class="ajax-link" href="ajax/page_feed.html">Feed</a></li>
								<li><a class="ajax-link add-full" href="ajax/page_messages.html">Messages</a></li>
								<li><a class="ajax-link" href="ajax/page_pricing.html">Pricing</a></li>
								<li><a class="ajax-link" href="ajax/page_product.html">Product</a></li>
								<li><a class="ajax-link" href="ajax/page_invoice.html">Invoice</a></li>
								<li><a class="ajax-link" href="ajax/page_search.html">Search Results</a></li>
								<li><a class="ajax-link" href="ajax/page_404.html">Error 404</a></li>
								<li><a href="ajax/page_500_v1.html">Error 500</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-map-marker"></i>
								<span class="hidden-xs">Maps</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/maps.html">OpenStreetMap</a></li>
								<li><a class="ajax-link" href="ajax/map_fullscreen.html">Fullscreen map</a></li>
								<li><a class="ajax-link" href="ajax/map_leaflet.html">Leaflet</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-picture-o"></i>
								 <span class="hidden-xs">Gallery</span>
							</a>
							<ul class="dropdown-menu">
								<li><a class="ajax-link" href="ajax/gallery_simple.html">Simple Gallery</a></li>
								<li><a class="ajax-link" href="ajax/gallery_flickr.html">Flickr Gallery</a></li>
							</ul>
						</li>
						<li>
							 <a class="ajax-link" href="ajax/typography.html">
								 <i class="fa fa-font"></i>
								 <span class="hidden-xs">Typography</span>
							</a>
						</li>
						 <li>
							<a class="ajax-link" href="ajax/calendar.html">
								 <i class="fa fa-calendar"></i>
								 <span class="hidden-xs">Calendar</span>
							</a>
						 </li>
					</ul>
				</li>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
<!--				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs">Charts</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/charts_xcharts.html">xCharts</a></li>
						<li><a class="ajax-link" href="ajax/charts_flot.html">Flot Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_google.html">Google Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_morris.html">Morris Charts</a></li>
						<li><a class="ajax-link" href="ajax/charts_amcharts.html">AmCharts</a></li>
						<li><a class="ajax-link" href="ajax/charts_chartist.html">Chartist</a></li>
						<li><a class="ajax-link" href="ajax/charts_coindesk.html">CoinDesk realtime</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-table"></i>
						 <span class="hidden-xs">Tables</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/tables_simple.html">Simple Tables</a></li>
						<li><a class="ajax-link" href="ajax/tables_datatables.html">Data Tables</a></li>
						<li><a class="ajax-link" href="ajax/tables_beauty.html">Beauty Tables</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-pencil-square-o"></i>
						 <span class="hidden-xs">Forms</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/forms_elements.html">Elements</a></li>
						<li><a class="ajax-link" href="ajax/forms_layouts.html">Layouts</a></li>
						<li><a class="ajax-link" href="ajax/forms_file_uploader.html">File Uploader</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-desktop"></i>
						 <span class="hidden-xs">UI Elements</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/ui_grid.html">Grid</a></li>
						<li><a class="ajax-link" href="ajax/ui_buttons.html">Buttons</a></li>
						<li><a class="ajax-link" href="ajax/ui_progressbars.html">Progress Bars</a></li>
						<li><a class="ajax-link" href="ajax/ui_jquery-ui.html">Jquery UI</a></li>
						<li><a class="ajax-link" href="ajax/ui_icons.html">Icons</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-list"></i>
						 <span class="hidden-xs">Pages</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="ajax/page_login_v1.html">Login</a></li>
						<li><a href="ajax/page_register_v1.html">Register</a></li>
						<li><a id="locked-screen" class="submenu" href="ajax/page_locked.html">Locked Screen</a></li>
						<li><a class="ajax-link" href="ajax/page_contacts.html">Contacts</a></li>
						<li><a class="ajax-link" href="ajax/page_feed.html">Feed</a></li>
						<li><a class="ajax-link add-full" href="ajax/page_messages.html">Messages</a></li>
						<li><a class="ajax-link" href="ajax/page_pricing.html">Pricing</a></li>
						<li><a class="ajax-link" href="ajax/page_product.html">Product</a></li>
						<li><a class="ajax-link" href="ajax/page_invoice.html">Invoice</a></li>
						<li><a class="ajax-link" href="ajax/page_search.html">Search Results</a></li>
						<li><a class="ajax-link" href="ajax/page_404.html">Error 404</a></li>
						<li><a href="ajax/page_500_v1.html">Error 500</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-map-marker"></i>
						<span class="hidden-xs">Maps</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/maps.html">OpenStreetMap</a></li>
						<li><a class="ajax-link" href="ajax/map_fullscreen.html">Fullscreen map</a></li>
						<li><a class="ajax-link" href="ajax/map_leaflet.html">Leaflet</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-picture-o"></i>
						 <span class="hidden-xs">Gallery</span>
					</a>
					<ul class="dropdown-menu">
						<li><a class="ajax-link" href="ajax/gallery_simple.html">Simple Gallery</a></li>
						<li><a class="ajax-link" href="ajax/gallery_flickr.html">Flickr Gallery</a></li>
					</ul>
				</li>
				<li>
					 <a class="ajax-link" href="ajax/typography.html">
						 <i class="fa fa-font"></i>
						 <span class="hidden-xs">Typography</span>
					</a>
				</li>
				 <li>
					<a class="ajax-link" href="ajax/calendar.html">
						 <i class="fa fa-calendar"></i>
						 <span class="hidden-xs">Calendar</span>
					</a>
				 </li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">
						<i class="fa fa-picture-o"></i>
						 <span class="hidden-xs">Multilevel menu</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">First level menu</a></li>
						<li><a href="#">First level menu</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-plus-square"></i>
								<span class="hidden-xs">Second level menu group</span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Second level menu</a></li>
								<li><a href="#">Second level menu</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle">
										<i class="fa fa-plus-square"></i>
										<span class="hidden-xs">Three level menu group</span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="#">Three level menu</a></li>
										<li><a href="#">Three level menu</a></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle">
												<i class="fa fa-plus-square"></i>
												<span class="hidden-xs">Four level menu group</span>
											</a>
											<ul class="dropdown-menu">
												<li><a href="#">Four level menu</a></li>
												<li><a href="#">Four level menu</a></li>
												<li class="dropdown">
													<a href="#" class="dropdown-toggle">
														<i class="fa fa-plus-square"></i>
														<span class="hidden-xs">Five level menu group</span>
													</a>
													<ul class="dropdown-menu">
														<li><a href="#">Five level menu</a></li>
														<li><a href="#">Five level menu</a></li>
														<li class="dropdown">
															<a href="#" class="dropdown-toggle">
																<i class="fa fa-plus-square"></i>
																<span class="hidden-xs">Six level menu group</span>
															</a>
															<ul class="dropdown-menu">
																<li><a href="#">Six level menu</a></li>
																<li><a href="#">Six level menu</a></li>
															</ul>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										<li><a href="#">Three level menu</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				-->
			</ul>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			<div id="about">
				<div class="about-inner">
					<h4 class="page-header">Admin Console, Open-source admin theme based on DevOOPS v2</h4>
				</div>
			</div>
			<div class="preloader">
				<img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
			</div>
			<div id="ajax-content"></div>
		</div>
		<!--End Content-->
	</div>
	<!-- Журнал -->
	<section class="core-messages">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<div class="box-name">
							<i class="fa fa-info"></i>
							<span>Журнал</span>
						</div>
						<div class="box-icons">
							<a class="collapse-link">
								<i class="fa fa-chevron-down"></i>
							</a>
							<a class="expand-link">
								<i class="fa fa-expand"></i>
							</a>
							<a class="cl-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
						<div class="no-move"></div>
					</div>
					<div class="box-content no-padding">
						<table id="logger" class="table table-striped table-bordered table-hover table-heading"></table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /Журнал -->
	<div id="clipboard-container"><div id="clipboard"></div></div>
</div>
<!--End Container-->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="plugins/jquery/jquery.min.3.5.0.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
<script src="plugins/ckfinder/ckfinder.js"></script>

<!--
<script src="plugins/justified-gallery/jquery.justifiedGallery.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
-->

<!-- All functions for this theme + document.ready processing -->
<script src="js/jquery.cookie.js"></script>
<script src="plugins/BootSideMenu/js/BootSideMenu.js"></script>
<script src="js/devoops.js"></script>
<script src="js/main.js"></script>






</body>
</html>
