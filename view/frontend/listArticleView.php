<?php session_start();?>
<?php $title = 'Accueil' ?>
<?php ob_start(); ?>
		<h1>Bienvenue sur mon blog</h1>
		<?php
		foreach($articles as $article){
		?>
			<div class="article"> 

				<h3> <?=$article['titre']?></h3>
				<p><?= $article['description']?></p>
				<p>
				<?= $article['date_creation']?>
				<a href="index.php?action=article&id=<?=$article['id']?>">Affichez l'article</a>
				</p>
			</div>
		<?php	
		}
		?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>