<?php $title = 'Accueil' ?>
<?php $css ='<link href\'public/css/style.css\' rel=stylesheet' ?>
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
				<a href="index.php?action=post&id=<?=$article['id']?>">Affichez l'article</a>
				</p>
			</div>
		<?php	
		}
		?>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>