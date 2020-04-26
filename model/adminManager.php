<?php
require_once("model/manager.php");

class GestionAdmin extends Manager{
	
	public function getAdmin(){
		$db = $this->dbConnect();
		$getAdmin = $db->query('SELECT id_admin, identifiant, password, password_change FROM administration WHERE id_admin = 1');
		$getAdmin = $getAdmin->fetch();
		return $getAdmin;
	}

	public function getCommentsAdmin(){
		$db = $this->dbConnect();
		$commentsAdmin = $db->query('SELECT commentaire.id id, article.titre titre, commentaire.auteur auteur, commentaire.commentaire commentaire, commentaire.date_commentaire date_commentaire, commentaire.signale signale FROM commentaire INNER JOIN article ON article.id = commentaire.id_article ORDER BY date_commentaire DESC');
		$commentsAdmin = $commentsAdmin->fetchAll();
		return $commentsAdmin;
	}

	public function addCommentVerif($signale, $id_commentaire){
		$db = $this->dbConnect();
		$confirmVerifComment = $db->prepare('UPDATE commentaire SET signale = ? WHERE id = ?');
		$confirmVerifComment->execute(array($signale ,$id_commentaire));
		
		return $confirmVerifComment;

	}

	public function supprComment($id_commentaire){
		$db = $this->dbConnect();
		$confirmSupprComment = $db->prepare('DELETE FROM commentaire WHERE id= ?');
		$confirmSupprComment->execute(array($id_commentaire));
	}

	public function addArticle($titre, $description, $contenu){
		$db = $this->dbConnect();
		$addArticle = $db->prepare('INSERT INTO article(titre, description, texte, date_creation) VALUES(?,?,?, NOW())');
		$confirmAddArticle= $addArticle->execute(array($titre,$description,$contenu));

		return $confirmAddArticle;
	}

	public function modifPassowrd($password, $identifiant ){
		$db = $this->dbConnect();
		$confirmModifPassword = $db->prepare('UPDATE administration SET password = ?, password_change = 1 WHERE identifiant = ?');
		$confirmModifPassword->execute(array($password, $identifiant));

		return $confirmModifPassword;
	}

}