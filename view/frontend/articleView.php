﻿<?php $title = 'Article'?>
<?php $css = '<link rel="stylesheet" type="text/css" href="public/css/articleView.css">'?>
<?php ob_start();?>
	<section>
		<h2><?=$article->titre?></h2>
		<p><?=$article->texte ?></p>
		<div>
		
			<?php
			if($article->id != 1){?>
				<a href="index.php?action=article&id=<?=$article->previousArticle?>">Article Précédent</a>
			<?php } ?>
			<?php
			if($article->nextArticle == true){?>
			
				<a href="index.php?action=article&id=<?=$article->nextArticle?>">Article Suivant</a>
			<?php
			}
			?>
		</div>
		<hr>
	</section>
	
	<section class='postCommentaire'>
		<h3>Commentaires</h3>
		<form action="index.php?action=addComment&amp;id=<?= $article->id ?>" method="post">
			<div>
				<label for="auteur">Auteur</label><br/>
				<input type="text" id="auteur" name="auteur"/>
			</div>
			<div>
				<label for="commentaire"> Commentaire</label><br/>
				<textarea id="commentaire" name="commentaire"></textarea>
			</div>
			<div>
				<input type="submit"/>
			</div>
		</form>
		<hr>
	</section>
	<section class='commentaires'>
		<?php
			foreach($comments as $comment)
			{
			?>
			<div class='commentaire'>	
				<p><?=$comment['auteur']?> le <?= $comment['date_commentaire']?></p>
				<p><?=$comment['commentaire']?></p>
				<?php
				if($comment['signale'] == NULL){?>
					<form action="index.php?action=addSignale&amp;id_commentaire=<?=$comment['id']?>&id_article=<?=$article->id?>" method="post"><input type='submit' value="Signaler le commentaire"></input></form>
				<?php
				}
				?>
				<hr>
			</div>	
				
			<?php
			}
		?>
	</section>	

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>