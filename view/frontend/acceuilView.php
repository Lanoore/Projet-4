<?php $title = 'Accueil' ?>

<?php ob_start(); ?>
		<h1>Bienvenue sur mon blog</h1>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>