<?php $title = 'Article'?>
<?php $css = '<link href\'public/css/style.css\' rel=stylesheet' ?>
<?php ob_start();?>
	<h3><?=$article['titre']?></h3>
	<p><?= $article['texte'] ?></p>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>