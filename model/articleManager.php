<?php
require_once('model/manager.php');

class ArticleManager extends Manager{

	function __construct($idArticle){
		$this->idArticle = $idArticle;


		$this->getArticle();


		$this->getArticleSuivant();
		$this->getArticlePrecedent();
			
	}


	public static function getArticles($depart,$articlesParPage){
		//Récupére les articles à afficher
		$db = self::dbConnect();
		$req = $db->query('SELECT id, titre, description, date_creation FROM article ORDER BY date_creation DESC LIMIT '.$depart.','.$articlesParPage);

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

	public static function getNbArticles(){
		//Récupère le nombre d'articles à afficher sur la page en cours de visionnage
		$db = self::dbConnect();
		$articlesNb = $db->prepare('SELECT id FROM article');
		$articlesNb->execute(array());
		$articlesNb = $articlesNb->rowCount();
		$articlesParPage = 8;
		$articlesTotaux = ceil($articlesNb/$articlesParPage);

		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page']> 0 AND $_GET['page'] <=$articlesTotaux){
			$_GET['page'] = intval($_GET['page']);
			$pageCourante = $_GET['page'];
		}else{
			$pageCourante = 1;
		}

		$depart = ($pageCourante-1)*$articlesParPage;
		
		return array($depart,$articlesParPage, $articlesTotaux,$pageCourante);

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

	public static function addArticle(){
		//Permet d'ajouter un article
		$titre = htmlentities($_POST['titre']);
		$description = htmlentities($_POST['description']);
		$contenu = htmlentities($_POST['contenu']);

		$db = self::dbConnect();
		$addArticle = $db->prepare('INSERT INTO article(titre, description, texte, date_creation) VALUES(?,?,?, NOW())');
		$confirmAddArticle= $addArticle->execute(array($titre,$description,$contenu));

		return $confirmAddArticle;



	}


	public static function supprArticle(){
		//Permet de supprimer un article ansi que via la clé étrangère les commentaires associés
		$db = self::dbConnect();
		$req = $db->prepare('DELETE FROM article WHERE id = ?');
		$confirmSuppr = $req->execute(array($_GET['id_article']));

		return $confirmSuppr;

	}

	public static function modifArticle(){
		//Permet de modifier un article
		$titre = htmlentities($_POST['titre']);
		$description = htmlentities($_POST['description']);
		$contenu = htmlentities($_POST['contenu']);

		$db = self::dbConnect();
		$req = $db->prepare('UPDATE article SET titre = ?, description = ?, texte = ?  WHERE id = ?');
		$confirmModif = $req->execute(array($titre,$description,$contenu, $_GET['id_article']));

		return $confirmModif;

		
	}

}
