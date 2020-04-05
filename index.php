<?php 
	require('controller/base.php');
	try{
		if (isset($_GET['action'])) {

			throw new Exception('Aucune action');	
		}
		else{
			afficheAccueil();
		}
	}
	catch(Exception $e){
		echo "Erreur : " . $e->getMessage();
	}




