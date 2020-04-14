<?php

require('model/articleManager.php');
require('model/commentManager.php');


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

