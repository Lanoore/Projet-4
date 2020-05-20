
<?php $title = 'admin'?>
<!-- CSS -->
<?php $script = '<script src="https://cdn.tiny.cloud/1/amz2qjsjr01macp4mb7y8pp67yd2hezik8v80zu2a2v8rww6/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script><script>tinymce.init({selector: \'#articleArea\'});</script>'?>




<?php ob_start(); ?>

<form action='index.php?action=addArticle' method='post'>
    <div>
        <label for="titre">Titre</label><br/>
        <input type='text' name='titre' ></input>
    </div>

    <div>
        <label for="description">Description</label><br/>
        <input type='text' name='description'></input>
    </div>
    
    
    <textarea id='articleArea' value='contenu' name='contenu'> </textarea>
    <input type='submit'></input>
</form>


<?php $content = ob_get_clean(); ?>
<?php require ('template.php');