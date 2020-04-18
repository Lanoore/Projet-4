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
			elseif($_GET['action'] == 'addSignale'){
				if(isset($_GET['id_commentaire'])&& $_GET['id_commentaire'] > 0 && isset($_GET['id_article'])&& $_GET['id_article']>0){
					addSignaleCommentaire($_GET['id_commentaire'], $_GET['id_article']);
				}
				else{
					throw new Exception('Un id de commentaire ainsi qu\'un id d\'article est requis ou est incorrect');
				}
			}
			elseif($_GET['action'] == 'admin'){
				accueilAdmin();
			}
			elseif($_GET['action'] == 'connectAdmin'){
				if(!empty($_POST['identifiant']) && !empty($_POST['password'])){
					if(!preg_match("#[<>]#", $_POST['identifiant']) && !preg_match("#[<>]#",$_POST['password'])){
						connectAdmin($_POST['identifiant'], $_POST['password']);
					}
					else{
						throw new Exception('Rentrer un identifiant et un mot de passe valide');
					}
				}
				else{
					throw new Exception('Tous les champs ne sont pas remplis');
				}
				
			}
			elseif($_GET['action'] == 'adminGestionView'){
				afficheGestionAdmin();
			}
			elseif($_GET['action'] == 'verifSignaleComment'){
				if(isset($_POST['Valider'])){
					verifComment($_GET['id_commentaire'], 1);
				}
				elseif(isset($_POST['Supprimer'])){
					verifComment($_GET['id_commentaire'], 0);
				}
			}
			else{
				afficheListArticles();
			}
		}
		else{
			afficheListArticles();
		}
	}
	catch(Exception $e){
		echo "Erreur : " . $e->getMessage();
	}




