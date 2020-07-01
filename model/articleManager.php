<?php
require_once('model/manager.php');

class ArticleManager extends Manager{

	function __construct($idArticle){
		$this->id = null;
		$this->titre = null;
		$this->description = null;
		$this->texte = null;
		$this->date = null;

		

		if($idArticle!= null){

			$this->idArticle = $idArticle;

			$this->getArticle();

			$this->getArticleSuivant();
			$this->getArticlePrecedent();
		}

		
			
	}


	public function getArticles(){
		//Récupére les articles à afficher
		$db = self::dbConnect();
		$req = $db->query('SELECT id, titre, description, date_creation FROM article ORDER BY date_creation DESC LIMIT '.$this->depart.','.$this->articlesParPage);

		return $req;
	}

	public function getArticle(){
		//Récupère les informations sur un article précis
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

	public static function verifIdArticleExist($articleId){
		$db = self::dbConnect();
		$req = $db->prepare('SELECT id FROM article WHERE id = ?');
		$req->execute(array($articleId));
		$req = $req->fetch();
		return $req;
	}

	public  function getNbArticles(){
		//Récupère le nombre d'articles à afficher sur la page en cours de visionnage
		$db = self::dbConnect();
		$articlesNb = $db->prepare('SELECT id FROM article');
		$articlesNb->execute(array());
		$articlesNb = $articlesNb->rowCount();
		$this->articlesNb = $articlesNb;


	}

	public function getArticleSuivant(){
		//Permet de connaitre l'id de l'article suivant
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id FROM article WHERE id = (SELECT min(id) FROM article WHERE id > ?)');
		$req->execute(array($this->idArticle));
		$nextArticle = $req->fetch();

		$this->nextArticle = $nextArticle['id'];
		return $nextArticle;
	}

	public function getArticlePrecedent(){
		//Permet de connaitre l'id de l'article précédent
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT id FROM article WHERE id =(SELECT max(id) FROM article WHERE id < ?)');
		$req->execute(array($this->idArticle));
		$previousArticle = $req->fetch();

		$this->previousArticle = $previousArticle['id'];
		return $previousArticle;
	}

	public function addArticle(){
		//Permet d'ajouter un article

		$db = self::dbConnect();
		$addArticle = $db->prepare('INSERT INTO article(titre, description, texte, date_creation) VALUES(?,?,?, NOW())');
		$confirmAddArticle= $addArticle->execute(array($this->titre,$this->descr,$this->texte));

		return $confirmAddArticle;



	}


	public static function supprArticle($id_article){
		//Permet de supprimer un article ainsi que via la clé étrangère les commentaires associés
		$db = self::dbConnect();
		$req = $db->prepare('DELETE FROM article WHERE id = ?');
		$confirmSuppr = $req->execute(array($id_article));

		return $confirmSuppr;

	}

	public function modifArticle(){
		//Permet de modifier un article
		

		$db = self::dbConnect();
		$req = $db->prepare('UPDATE article SET titre = ?, description = ?, texte = ?  WHERE id = ?');
		$confirmModif = $req->execute(array($this->titre,$this->description,$this->texte, $this->id));

		return $confirmModif;

		
	}

}
