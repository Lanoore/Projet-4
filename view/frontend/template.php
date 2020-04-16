<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
	<?php if(isset($css)){echo $css;} ?>
	<?php if(isset($script)){echo $script;}?>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
	<?= $content ?>
</body>
</html>