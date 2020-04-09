<?php 
	require('controller/base.php');
	try{
		if (isset($_GET['action'])) {

			if ($_GET['action'] == 'post') {
				if(isset($_GET['id']) && $_GET['id']> 0){
					afficheArticle();
				}
				else{
					throw new Exception('Aucun id de billet envoyé');
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




