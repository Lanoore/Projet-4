<?php
require_once('model/Manager.php');

class ArticleManager extends Manager{

	function __construct($idArticle){
		$this->idArticle = $idArticle;


		$this->getArticle();


		$this->getArticleSuivant();
		$this->getArticlePrecedent();
			
	}


	public static function getArticles(){
		$db = self::dbConnect();
		$req = $db->query('SELECT id, titre, description, date_creation FROM article ORDER BY date_creation DESC');

		return $req;
	}

	public function getArticle(){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id, titre, description, texte, date_creation FROM article WHERE id = ?');
		$req->execute(array($this->idArticle));
		$article = $req->fetch();

		$this->id = $article['id'];
		$this->titre = $article['titre'];
		$this->description = $article['description'];
		$this->texte = html_entity_decode($article['texte']);;
		$this->date = $article['date_creation'];
		
		
		return $article;
	}

	public function getArticleSuivant(){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id FROM article WHERE id = (SELECT min(id) FROM article WHERE id > ?)');
		$req->execute(array($this->idArticle));
		$nextArticle = $req->fetch();

		$this->nextArticle = $nextArticle['id'];
		return $nextArticle;
	}

	public function getArticlePrecedent(){
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id FROM article WHERE id =(SELECT max(id) FROM article WHERE id < ?)');
		$req->execute(array($this->idArticle));
		$previousArticle = $req->fetch();

		$this->previousArticle = $previousArticle['id'];
		return $previousArticle;
	}

	public static function addArticle(){

		$titre = htmlentities($_POST['titre']);
		$description = htmlentities($_POST['description']);
		$contenu = htmlentities($_POST['contenu']);

		$db = self::dbConnect();
		$addArticle = $db->prepare('INSERT INTO article(titre, description, texte, date_creation) VALUES(?,?,?, NOW())');
		$confirmAddArticle= $addArticle->execute(array($titre,$description,$contenu));

		if($confirmAddArticle === true){
			header('Location: index.php?action');
		}
		else{
			throw new Exception('L\'article n\'a pas pu etre envoyer');
		}

	}


	public static function supprArticle(){
		$db = self::dbConnect();
		$req = $db->prepare('DELETE FROM article WHERE id = ?');
		$confirmSuppr = $req->execute(array($_GET['id_article']));

		if($confirmSuppr === true){
			header('Location:index.php?action=adminGestionView');
		}	
		else{
			throw new Exception('L\'article n\'a pas pu etre supprimer');
		}
	}

	public static function modifArticle(){

		$titre = htmlentities($_POST['titre']);
		$description = htmlentities($_POST['description']);
		$contenu = htmlentities($_POST['contenu']);

		$db = self::dbConnect();
		$req = $db->prepare('UPDATE article SET titre = ?, description = ?, texte = ?  WHERE id = ?');
		$confirmModif = $req->execute(array($titre,$description,$contenu, $_GET['id_article']));

		if($confirmModif === true){
			header("Location: index.php?action");
		}
		else{
			throw new Exception('L\'article n\'a pas pu etre modifier');
		}
	}

}
