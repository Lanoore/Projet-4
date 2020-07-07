<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
	<?php if(isset($css)){echo $css;} ?>
	<script src="https://kit.fontawesome.com/b8189872a7.js"></script>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no">
</head>
<body>
	<header>
		<nav>
			<a href='index.php'><i class="fas fa-home fa-2x"></i></a>
			<a href='index.php?action=info'><i class="fas fa-info-circle fa-2x"></i></a>
		</nav>
	</header>
	<section>
		<?= $content ?>
</section>
	<footer>
		<p>© 2020 All rights reserved</p>
	</footer>

	<?php if(isset($script)){echo $script;}?>
</body>

</html>