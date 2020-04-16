<?php

require('model/articleManager.php');
require('model/commentManager.php');
require('model/adminManager.php');


function afficheListArticles(){
	
	$listArticleManager = new ArticleManager();

	$articles = $listArticleManager->getArticles();

	require('view/frontend/listArticleView.php');	
}

function afficheArticle(){

	$articleManager = new ArticleManager();
	$article = $articleManager->getArticle($_GET['id']);

	$commentManager = new CommentManager();
	$comments = $commentManager->getComments($_GET['id']);

	require('view/frontend/articleView.php');
}

function addComment($articleId, $auteur, $comment){

	$commentManager = new CommentManager();
	$confirmCommentAdd = $commentManager->addComment($articleId, $auteur, $comment);

	if($confirmCommentAdd === false){
		throw new Exception ('Impossible d\'ajouter le commentaire!');
	}
	else{
		header('Location: index.php?action=article&id='.$articleId);
	}
}


function accueilAdmin(){
	require('view/frontend/accueilAdminView.php');
}

function connectAdmin($identifiant, $password){
	$adminManager = new GestionAdmin();
	$verifAdmin = $adminManager->getAdmin();



	if($verifAdmin['identifiant'] == $identifiant && $verifAdmin['password'] == $password){
		
		session_start();

		$_SESSION['identifiant'] = $identifiant;
		$_SESSION['id_admin'] = $verifAdmin['id_admin'];
		header('Location: index.php?action=adminGestionView');
	}
	else{
		throw new Exception('Mot de passe ou identifiant invalide');
	}
}


function afficheGestionAdmin(){
	$adminManager = new GestionAdmin(); 
	$commentsAdmin = $adminManager->getCommentsAdmin();
		
	require('view/frontend/adminGestionView.php');
}

