<?php $title = 'Article'?>
<?php ob_start();?>
	<div>
		<h3><?=$article['titre']?></h3>
		<p><?= $article['texte'] ?></p>
	</div>

	<h2>Commentaires</h2>
	<form action="index.php?action=addComment&amp;id=<?= $article['id'] ?>" method="post">
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
	<?php
		foreach($comments as $comment)
		{
		?>
			<p><?=$comment['auteur']?> le <?= $comment['date_commentaire']?></p>
			<p><?=$comment['commentaire']?></p>
		<?php
		}
	?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>