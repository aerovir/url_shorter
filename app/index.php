<?php
	include_once "includes/func.php";
	// $url = $_POST['ask'];
	// if ($url != null) {
	// 	$link = db_query("SELECT * FROM main_table WHERE short_link = '$url'")->fetch();
	// 	if(empty($link)) {
	// 		header('Location: 404.php');
	// 		die;
	// 	}
	// 	db_query("UPDATE main_table SET views = views + 1 WHERE short_link = '$url'", true);
	// 	header('Location: ' . $link['long_link']);
	// 	$_POST['ask'] = null;
	// 	die;
	// }

	if (isset($_GET['url']) && !empty($_GET['url'])) {
		$url = strtolower(trim($_GET['url']));

		$link = get_link_info($url);

		if (empty($link)) {
			header('Location: 404.php');
			die;
		}

		update_views($url);
		header('Location: ' . $link['long_link']);
		die;
	}
?>
<?php include_once "includes/header.php";?>
	<main class="container">
		<div class="row mt-5">
		<?php if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) { ?>
			<div class="col">
				<h2 class="text-center">Добро пожаловать <?php echo $_SESSION['user']['login']; ?></h2>
			</div>
							<?php } else { ?>
								<div class="col">
				<h2 class="text-center">Необходимо <a href="<?php echo get_URL('register.php'); ?>">зарегистрироваться</a> или <a href="<?php echo get_URL('login.php'); ?>">войти</a> под своей учетной записью</h2>
			</div>
							<?php } ?>
		
			
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php echo $user_count; ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php echo $count_url; ?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php echo $view_count; ?></h2>
			</div>
		</div>
	</main>
<?php include_once "includes/footer.php";?>