﻿
<?php $title = 'admin'?>
<?php $css ='<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">' ?>
<?php $script ='<script type=" text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js "></script><script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>    <script>$(document).ready(function(){$("#table_commentaire").DataTable();});</script>'?>
<?php ob_start(); ?>

    <a href='index.php?action=ajoutArticle' >Ajouter un nouvel article</a>
    <a href='index.php?action=modifPassword'> Changer le mot de passe</a>

     <table id="table_commentaire">
        <thead>
            <tr>
                <th>Nom de l'article</th>
                <th>Auteur</th>
                <th>Commentaire</th>
                <th>Date commentaire</th>
                <th>Signalé?</th>
            </tr>
        </thead>
        <tbody> 

            <?php
                foreach($commentsAdmin as $commentAdmin)
                {
                ?>
                <tr>
                    <td><?=$commentAdmin['titre']?></td>
                    <td><?=$commentAdmin['auteur']?></td>
                    <td><?=$commentAdmin['commentaire']?></td>
                    <td><?=$commentAdmin['date_commentaire']?></td>

                    <?php if($commentAdmin['signale']=== NULL){?>
                        <td>Non signalé <form action="index.php?action=verifSignaleComment&id_commentaire=<?=$commentAdmin['id']?>" method="post"><input type="submit" name="Valider" value="Valider"></input><input type="submit" name="Supprimer" value="Supprimer"></input></form></td>
                    <?php
					}
                    elseif($commentAdmin['signale'] == 0){?>
                        <td>Signalé<form action="index.php?action=verifSignaleComment&id_commentaire=<?=$commentAdmin['id']?>" method="post"><input type="submit" name="Valider" value="Valider"></input><input type="submit" name="Supprimer" value="Supprimer"></input></form></td>
                    <?php
                    }
                    elseif($commentAdmin['signale'] == 1){?>
                        <td>Vérifié</td>
                    <?php    
					}
                    ?>
                </tr>
                <?php
				}    
            ?>
        </tbody>
    </table>
<?php $content = ob_get_clean(); ?>
<?php require ('template.php');