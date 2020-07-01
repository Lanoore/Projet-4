<?php
require_once("model/manager.php");

class CommentManager extends Manager{

	function __construct($idArticle){
		$this->idArticle = null;
		$this->auteur = null;
		$this->commentaire = null;


		if($idArticle!= null){

			$this->idArticle = $idArticle;

		}
	}
	

	public function getComments(){
		//Récupère les commentaires à afficher
		$db = self::dbConnect();
		$comments = $db->prepare('SELECT id, auteur, commentaire, date_commentaire, signale FROM commentaire WHERE id_article = ? ORDER BY date_commentaire DESC LIMIT '.$this->depart.','.$this->commentaireParPage);
		$comments->execute(array($this->idArticle));

		return $comments;
	}

	public function getNbComments (){
		//Récupère le nombre de commentaires à afficher sur la page en cours de visionage 
		$db = self::dbConnect();
		$commentsNb = $db->prepare('SELECT id FROM commentaire WHERE id_article = ?');
		$commentsNb->execute(array($this->idArticle));
		$commentsNb = $commentsNb->rowCount();
		$this->commentsNb = $commentsNb;
	}

	public function addComment(){
		//Permet d'ajouter un commentaire
		$db= self::dbConnect();
		$comments = $db->prepare('INSERT INTO commentaire(id_article, auteur, commentaire ,date_commentaire) VALUES(?,?,?,NOW())');
		$confirmCommentAdd = $comments->execute(array($this->idArticle, $this->auteur, $this->commentaire));

		return $confirmCommentAdd;
		
		
	}

	public function getCommentSignale(){
		//Récupère les commentaires signale
		$db = self::dbConnect();
		$commentSignale = $db->prepare('SELECT signale FROM commentaire WHERE id = ?');
		$commentSignale->execute(array($this->idCommentaire));

		return $commentSignale;


		
	}

	public function addCommentSignale(){
		//Permet de signale un commentaire
		$db = self::dbConnect();
		$confirmAddCommentSignale = $db->prepare('UPDATE commentaire SET signale = 0 WHERE id = ?');	
		$confirmAddCommentSignale->execute(array($this->idCommentaire));

		return $confirmAddCommentSignale;
	}

	public function addCommentVerif(){
		//Permet de vérifier un commentaire
		$db = self::dbConnect();
		$confirmVerifComment = $db->prepare('UPDATE commentaire SET signale = ? WHERE id = ?');
		$confirmVerifComment->execute(array($this->signale ,$this->idCommentaire));
		
		return $confirmVerifComment;

	}

	public function supprComment(){
		//Permet de supprimer un commentaire
		$db = self::dbConnect();
		$confirmSupprComment = $db->prepare('DELETE FROM commentaire WHERE id= ?');
		$confirmSupprComment->execute(array($this->idCommentaire));

		return $confirmSupprComment;
	}
}