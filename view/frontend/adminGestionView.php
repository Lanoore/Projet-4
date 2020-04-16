<?php 

session_start();?>
<?php $title = 'admin'?>
<?php $css ='<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">' ?>
<?php $script ='<script type=" text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js "></script><script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>    <script>$(document).ready(function(){$("#table_commentaire").DataTable();});</script>'?>
<?php ob_start(); ?>
        
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
                    <td><?=$commentAdmin['id_article']?></td>
                    <td><?=$commentAdmin['auteur']?></td>
                    <td><?=$commentAdmin['commentaire']?></td>
                    <td><?=$commentAdmin['date_commentaire']?></td>

                    <?php if($commentAdmin['signale']=== NULL){?>
                        <td>Non signalé</td>
                    <?php
					}
                    elseif($commentAdmin['signale'] == 0){?>
                        <td>Signalé(button à créer)</td>
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