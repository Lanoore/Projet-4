<?php 
	session_start();
	require('controller/base.php');


	try{
		if (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case 'article':
						afficheArticle($_GET['id']);
					break;
				case 'addComment':
						addComment($_GET['id']);
					break;
		
				case 'addSignale':
						addSignaleCommentaire($_GET['id_commentaire'], $_GET['id_article']);
					break;

				case 'admin':
					accueilAdmin();
					break;

				case 'connectAdmin':
							connectAdmin();
					break;

					case 'adminGestionView':
							afficheGestionAdmin();
						break;

					case 'verifSignaleComment':
							verifComment($_GET['id_commentaire']);
			
						break;

					case 'ajoutArticle':
							ajoutArticle();
						break;

					case 'addArticle':
							addArticle();
						
						break;

					case 'verifArticle':
							verifArticle();
						break;	

					case 'modifArticle':
							modifArticle();
						break;
					case 'modifPassword':
							modifPassword();
						break;

					case 'verifModifPassword':
							verifModifPassword();
						break;	
			default:
				afficheListArticles();
				break;
			}
		}
		else{
			afficheListArticles();
		}
	}
	catch(Exception $e){
		echo "Erreur : " . $e->getMessage();
	}