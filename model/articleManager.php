<?php
require_once('model/Manager.php');

class ArticleManager extends Manager{

	public function getArticles(){
		$db = $this->dbConnect();
		$req = $db->query('SELECT id, titre, description, date_creation FROM article ORDER BY date_creation DESC LIMIT 0, 5');

		return $req;
	}

	public function getArticle($articleId){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, titre, description, texte, date_creation FROM article WHERE id = ?');
		$req->execute(array($articleId));
		$article = $req->fetch();

		return $article;
	}
}
