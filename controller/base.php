<?php

require('model/articleManager.php');


function afficheListArticles(){
	
	$listArticleManager = new ArticleManager();

	$articles = $listArticleManager->getArticles();

	require('view/frontend/listArticleView.php');	
}

function afficheArticle(){

	$articleManager = new ArticleManager();
	$article = $articleManager->getArticle($_GET['id']);

	require('view/frontend/articleView.php');
}

