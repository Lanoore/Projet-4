<?php $title = 'Administration'?>
<?php ob_start(); ?>

	<form action="index.php?action=connectAdmin" method="post">
		<div>
			<label for = "identifiant"> Identifiant</label><br/>
			<input type="text" id="identifiant" name="identifiant"> 
		</div>
		<div>
			<label for="password">Mot de passe</label><br/>
			<input type="password" id="password" name="password">
		</div>
		<div>
			<input type="submit">
		</div>

	</form>

<?php $content = ob_get_clean(); ?>
<?php require ('template.php');
