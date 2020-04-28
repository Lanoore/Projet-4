
<?php $title = 'Accueil' ?>
<?php $css = '<link rel="stylesheet" type="text/css" href="public/css/listArticleView.css">'?>
<?php ob_start(); ?>
		<h1>Bienvenue sur le blog de Jean Forteroche </h1>
		<section class='articleList'>
			<?php
			foreach($articles as $article){
			?>
				<div class="article"> 

					<h3> <?=$article['titre']?></h3>
					<p><?= $article['description']?></p>
					<p><?= $article['date_creation']?></p>

					<a href="index.php?action=article&id=<?=$article['id']?>">Affichez l'article</a>
					<hr>
				</div>
				<br>
			<?php	
			}
			?>
		</section>	
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>