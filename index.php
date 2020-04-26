<?php 
	session_start();
	require('controller/base.php');
	try{
		if (isset($_GET['action'])) {

			if ($_GET['action'] == 'article') {
				if(isset($_GET['id']) && $_GET['id']> 0){
					afficheArticle();
				}

				else{
					throw new Exception('Aucun id de billet envoy�');
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
					throw new Exception('Aucun identifiant de billet envoy�');
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
				if(isset($_SESSION['identifiant'])){
					afficheGestionAdmin();
				}
				else{
					var_dump($_SESSION);
				}
				
			}
			elseif($_GET['action'] == 'verifSignaleComment'){
				if($_SESSION['identifiant']){
					if(isset($_POST['Valider'])){
						verifComment($_GET['id_commentaire'], 1);
					}
					elseif(isset($_POST['Supprimer'])){
						verifComment($_GET['id_commentaire'], 0);
					}
				}	
			}
			elseif($_GET['action'] == 'ajoutArticle'){
				ajoutArticle();
			}
			elseif($_GET['action'] == 'addArticle'){
				if(!preg_match("#[<>]#", $_POST['titre']) && !preg_match("#[<>]#",$_POST['description'])){
					addArticle();
				}
				else{
					throw new Exception('Le titre ou la description n\'est pas valide');
				}
			}
			elseif($_GET['action'] == 'modifPassword'){
				modifPassword();
			}
			elseif($_GET['action'] == 'verifModifPassword'){
				if(!preg_match("#[<>]#", $_POST['ancienPassowrd']) && !preg_match("#[<>]#",$_POST['nouveauPassword']) && !preg_match("#[<>]#",$_POST['nouveauPasswordVerif'])){
					verifModifPassword();
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




