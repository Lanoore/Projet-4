<?php



require('model/articleManager.php');
require('model/commentManager.php');
require('model/adminManager.php');


function afficheListArticles(){
	
	$articlesNb = articleManager::getNbArticles();

	$articles = articleManager::getArticles($articlesNb[0],$articlesNb[1]);

	require('view/frontend/listArticleView.php');	
}

function afficheArticle(){

	$article = new ArticleManager($_GET['id']);

	$commentsNb = CommentManager::getNbComments($_GET['id']);

	$comments = CommentManager::getComments($_GET['id'],$commentsNb[0],$commentsNb[1]);


	require('view/frontend/articleView.php');
}

function addComment($articleId, $auteur, $comment){

	$confirmCommentAdd = CommentManager::addComment($articleId, $auteur, $comment);

}

function addSignaleCommentaire($id_commentaire, $id_article){

	$confirmAddSignale = CommentManager::getCommentSignale($id_commentaire, $id_article);

}



function accueilAdmin(){
	require('view/frontend/accueilAdminView.php');
}

function connectAdmin($identifiant, $password){
	$adminManager = new GestionAdmin($identifiant);
	
	$passwordCorrect  = password_verify($password, $adminManager->password);

		if($passwordCorrect){
			header('Location:index.php?action=adminGestionView');
			$_SESSION['identifiant'] = $identifiant;
			$_SESSION['id_admin'] = $adminManager->id_admin;
			
			
		}
		else{
			throw new Exception('Mot de passe ou identifiant invalide');
		}
}


function afficheGestionAdmin(){
		
		$commentsAdmin = GestionAdmin::getCommentsAdmin();


		$articlesAdmin = GestionAdmin::getArticlesAdmin();

		require('view/frontend/adminGestionView.php');
}


function verifComment($id_commentaire,$signale){

		if($signale == 1){
			$verifComment = CommentManager::addCommentVerif($signale, $id_commentaire);
			header('Location: index.php?action=adminGestionView');
		}
		elseif($signale == 0){
			$supprComment = CommentManager::supprComment($id_commentaire);
			header('Location: index.php?action=adminGestionView');
		}
}

function ajoutArticle(){
		require('view/frontend/ajoutArticleView.php');
}

function addArticle(){

	$addArticle = ArticleManager::addArticle();

}

function modifPassword(){

	require('view/frontend/modifPasswordView.php');
}

function verifModifPassword(){
	$adminManager = new GestionAdmin($_SESSION['identifiant']);
	

	if($_POST['nouveauPassword'] == $_POST['nouveauPasswordVerif']){
		$password_hache = password_hash($_POST['nouveauPassword'], PASSWORD_DEFAULT);
		if($_POST['ancienPassowrd'] == $adminManager->password){

			$modifPassword = $adminManager->modifPassowrd($password_hache, $_SESSION['identifiant']);
			if($modifPassword == true){
				header('Location: index.php?action=adminGestionView');
			}
		}
		
		
		$passwordCorrect  = password_verify($_POST['ancienPassowrd'], $adminManager->password);

		if($passwordCorrect){
			$modifPassword = $adminManager->modifPassowrd($password_hache, $_SESSION['identifiant']);
			if($modifPassword == true){
				header('Location: index.php?action=adminGestionView');
			}	
		}
	}	
}
function verifArticle(){

	if(isset($_POST['Supprimer'])){
		$adminManager = ArticleManager::supprArticle();
	}
	elseif(isset($_POST['Modifier'])){

		$article = new ArticleManager($_GET['id_article']);

		require('view/frontend/modifArticleView.php');
	}
}

function modifArticle(){

	$adminManager = ArticleManager::modifArticle();
}

