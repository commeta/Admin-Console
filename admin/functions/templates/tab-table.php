<!-- Таблица -->
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name"> <i class="fa fa-link"></i> <span>URL:</span> </div>
				<div class="box-icons">
					<a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
					<a class="expand-link"> <i class="fa fa-expand"></i> </a>
					<a class="close-link"> <i class="fa fa-times"></i> </a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding table-responsive bg-tab">
				<table class="table beauty-table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-main">
					<thead>
						<tr>
							<th style="white-space:nowrap; width:30px;">ID</th>
							<th>URL</th>
							<th>Title</th>
							<th style="white-space:nowrap; width:130px;">Действия</th>
						</tr>
					</thead>
					<tbody> </tbody>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>URL</th>
							<th>Title</th>
							<th>Действия</th>
						</tr>
					</tfoot>
				</table>
				<ul class="list-inline text-center">
					<li>
						<button class="btn btn-default add-url" onclick="create_url();"><i class="fa fa-plus"></i> Добавить URL</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /Таблица  -->
