<?php
require_once("model/manager.php");


class GestionAdmin extends Manager{
	function __construct($identifiant){
		$this->identifiant = $identifiant;

		$getAdmin = $this->getAdmin();

		if(empty($getAdmin)){
			$password = password_hash('1234', PASSWORD_DEFAULT);
			$this->identifiant = 'admin';
			$this->password = $password;
			$this->insertAdmin();
		}

	}
	

	public function getAdmin(){
		//Permet de récupérer les différentes informations de l'admin
		$db = $this->dbConnect();
		$getAdmin = $db->query('SELECT id_admin, identifiant, password FROM administration WHERE identifiant ="'.$this->identifiant.'"');
		$getAdmin = $getAdmin->fetch();

		$this->id_admin = $getAdmin['id_admin'];
		$this->identifiant = $getAdmin['identifiant'];
		$this->password = $getAdmin['password'];
		return $getAdmin;
	}

	public function insertAdmin(){
		//Permet d'insérer un admin par défaux 
		$db = $this->dbConnect();
		$insertAdmin = $db->prepare('INSERT INTO administration(identifiant, password) VALUES(?,?)');
		$insertAdmin = $insertAdmin->execute(array($this->identifiant, $this->password));
	}

	public static function getArticlesAdmin(){
		//Récupére les articles pour la partie administration
		$db = self::dbConnect();
		$req = $db->query('SELECT id, titre, description, date_creation FROM article ORDER BY date_creation DESC');

		return $req;
	}

	public static function getCommentsAdmin(){
		//Récupére les commentaires pour la partie administration
		$db = self::dbConnect();
		$commentsAdmin = $db->query('SELECT commentaire.id id, article.titre titre, commentaire.auteur auteur, commentaire.commentaire commentaire, commentaire.date_commentaire date_commentaire, commentaire.signale signale FROM commentaire INNER JOIN article ON article.id = commentaire.id_article ORDER BY date_commentaire DESC');
		$commentsAdmin = $commentsAdmin->fetchAll();
		return $commentsAdmin;
	}


	public function modifPassowrd(){
		//Permet de modifier le mot de passe dans la bdd
		$db = $this->dbConnect();
		$confirmModifPassword = $db->prepare('UPDATE administration SET password = ?, password_change = 1 WHERE identifiant = ?');
		$confirmModifPassword->execute(array($this->password_hache, $this->identifiant));

		return $confirmModifPassword;
	}

	

}