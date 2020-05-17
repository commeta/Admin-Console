<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<div class="sidebar-sticky">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link active" href="/profile/"> <span data-feather="home"></span> Кабинет <span class="sr-only">(current)</span> </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile/orders/"> <span data-feather="file"></span> Заказы </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile/services/"> <span data-feather="shopping-cart"></span> Услуги </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile/settings/"> <span data-feather="users"></span> Личные данные </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile/reports/"> <span data-feather="bar-chart-2"></span> Отчеты </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile/documents/"> <span data-feather="layers"></span> Документы </a>
					</li>
				</ul>
				<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
				  <span>Saved reports</span>
				  <a class="d-flex align-items-center text-muted" href="#">
					<span data-feather="plus-circle"></span>
				  </a>
				</h6>
				<ul class="nav flex-column mb-2">
					<li class="nav-item">
						<a class="nav-link" href="#"> <span data-feather="file-text"></span> Current month </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <span data-feather="file-text"></span> Last quarter </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <span data-feather="file-text"></span> Social engagement </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <span data-feather="file-text"></span> Year-end sale </a>
					</li>
				</ul>
			</div>
		</nav>
		
		
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
<?php
if($page === false) $page= 'dashboard';

require_once(pages_dir."chanks/profile/$page.php");
?>
		</main>
	</div>
</div>



<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
	feather.replace()
</script>


