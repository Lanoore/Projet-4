<?php $title = 'admin'?>
<?php ob_start(); ?>

<form action='index.php?action=verifModifPassword' method='post'>

    <div>
        <label for="ancienPassword">Ancien mot de passe</label><br/>
        <input type='password' name='ancienPassword' ></input>
    </div>
    <div>
        <label for="nouveauPassword">Nouveau mot de passe</label><br/>
        <input type='password' name='nouveauPassword' ></input>
    </div>
    <div>
        <label for="nouveauPasswordVerif">Rentrer de nouveau votre mot de passe</label><br/>
        <input type='password' name='nouveauPasswordVerif' ></input>
    </div>
    <div>
        <input type='submit'></input>
    </div>

</form>

<?php $content = ob_get_clean(); ?>
<?php require ('template.php');