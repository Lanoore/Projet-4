<?php $title = 'Information'?>
<?php $css = '<link rel="stylesheet" type="text/css" href="public/css/infoView.css">'?>
<?php ob_start(); ?>

    <section>
        <h3>Qui suis-je ?</h3>
        <div>
            <p>Je m'appelle Jean Forteroche, née d'un père belge et d'une mère française je vis à Bruxelles pendant toute mon enfance.</br></br>
            C'est pendant cette dernière que me vient la passion de l'écriture, lorsque mes études me conduisent en France je décide de partir sur une école de théâtre et de lettres.</br></br>
            Une fois mon diplôme acquis je décide de m'engager pleinement dans l'écriture de mes romans au début sous format papier dans les librairies puis sur internet.</p>
            <img src="img/jean_forteroche.jpg" alt="jean_forteroche" width="50%">
        </div>
        
    </section>

<?php $content = ob_get_clean(); ?>
<?php require ('template.php');