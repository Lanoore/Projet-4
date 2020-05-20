<?php $title = 'admin'?>
<?php $css?>
<?php $script= '<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script><script>tinymce.init({selector: \'#articleArea\'});</script>'?>
<?php ob_start(); ?>


<form action='index.php?action=modifArticle&id_article=<?=$article->id?>' method='post'>
    <div>
        <?='<label for="titre">Titre</label><br/>
        <input type="text" name="titre" value = "',htmlspecialchars($article->titre, ENT_QUOTES, 'UTF-8'),'"></input>'?>
    </div>

    <div>
        <?='<label for="description">Description</label><br/>
        <input type="text" name="description" value ="' ,htmlspecialchars($article->description, ENT_QUOTES, 'UTF-8'),'"></input>'?>
    </div>
    
    
    <textarea id='articleArea' name ='contenu'><?=$article->texte?></textarea>
    <input type='submit'></input>
</form>


<?php $content = ob_get_clean(); ?>
<?php require ('template.php');