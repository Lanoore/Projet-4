<?php
require_once("model/manager.php");

class GestionAdmin extends Manager{
	
	public function getAdmin(){
		$db = $this->dbConnect();
		$getAdmin = $db->query('SELECT id_admin, identifiant, password FROM administration WHERE id_admin = 1');
		$getAdmin = $getAdmin->fetch();
		return $getAdmin;
	}

	public function getCommentsAdmin(){
		$db = $this->dbConnect();
		$commentsAdmin = $db->query('SELECT id, id_article, auteur, commentaire, date_commentaire, signale FROM commentaire ORDER BY date_commentaire DESC');
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

}