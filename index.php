<?php 
	require('controller/base.php');
	try{
		if (isset($_GET['action'])) {

			if ($_GET['action'] == 'article') {
				if(isset($_GET['id']) && $_GET['id']> 0){
					afficheArticle();
				}

				else{
					throw new Exception('Aucun id de billet envoyé');
				}
			}
			elseif($_GET['action'] == 'addComment'){
				if(isset($_GET['id'])&& $_GET['id'] > 0){
					if(!empty($_POST['auteur'])&& !empty($_POST['commentaire'])){
						if(!preg_match("#[<>]#", $_POST['auteur']) && !preg_match("#[<>]#",$_POST['commentaire'])){
							addComment($_GET['id'], $_POST['auteur'], $_POST['commentaire']);
						}
						else{
							
							throw new Exception('Rentrer un pseudo et un commentaire valide');
						}
					}
					else{
						throw new Exception('Tous les champs ne sont pas remplis!');
					}
				}
				else{
					throw new Exception('Aucun identifiant de billet envoyé');
				}
			}
		}
		else{
			afficheListArticles();
		}
	}
	catch(Exception $e){
		echo "Erreur : " . $e->getMessage();
	}




