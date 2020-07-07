
<?php $title = 'Accueil' ?>
<?php $css = '<link rel="stylesheet" type="text/css" href="public/css/listArticleView.css">'?>
<?php ob_start(); ?>
		<h1>Bienvenue sur le blog de Jean Forteroche </h1>
		<section class='articleList'>
			<?php
			foreach($articles as $article){
			?>
				<article class="article"> 

					<h2> <?=$article['titre']?></h2>
					<p><?= $article['description']?></p>
					<p><?= $article['date_creation']?></p>

					<a class='buttonArticle' href="index.php?action=article&id=<?=$article['id']?>&page=1">Affichez l'article</a>

				</article>
				
			<?php	
			}

			
			?>
		</section>
		<div class='paginationArticle'>
			<?php
			for($i=1;$i<=$articlesTotaux; $i++){
				if($i == $pageCourante){
					echo '<span>'.$i.'</span>';
				}
				else{
					echo '<span><a href="index.php?action&page='.$i.'">'.$i.'</a></span>';
				}
			}
			
			?>
		</div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>