<main role="main" class="text-center">
	<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h1 class="display-4 font-italic">Подтверждение Email</h1>
		</div>
	</div>
	
	<div class="container marketing ">
<?php
if($submod && $subpage){
	if(confirm_user_email($submod, $subpage)){
		echo "<h1>Email Подтвержден.</h1><p>Можете зайти в личный кабинет</p>";
	} else {
		echo "<h1>Email Не Подтвержден.</h1><p>Ошибочный параметр</p>";
	}
} else {
	echo "<h1>Email Не Подтвержден.</h1><p>Ошибочный параметр</p>";
}
?>

	</div>

</main>


