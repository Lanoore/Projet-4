<?php
require_once("model/manager.php");

class CommentManager extends Manager{

	

	public static function getComments($postId, $depart,$commentaireParPage){
		//Récupère les commentaires à afficher
		$db = self::dbConnect();
		$comments = $db->prepare('SELECT id, auteur, commentaire, date_commentaire, signale FROM commentaire WHERE id_article = ? ORDER BY date_commentaire DESC LIMIT '.$depart.','.$commentaireParPage);
		$comments->execute(array($postId));

		return $comments;
	}

	public static function getNbComments ($postId){
		//Récupère le nombre de commentaires à afficher sur la page en cours de visionage 
		$db = self::dbConnect();
		$commentsNb = $db->prepare('SELECT id FROM commentaire WHERE id_article = ?');
		$commentsNb->execute(array($postId));
		$commentsNb = $commentsNb->rowCount();
		$commentaireParPage = 5;
		$commentairesTotaux = ceil($commentsNb/$commentaireParPage);

		if(isset($_GET['page']) AND  !empty($_GET['page']) AND $_GET['page']> 0 AND $_GET['page'] <=$commentairesTotaux){
			$_GET['page'] = intval($_GET['page']);
			$pageCourante = $_GET['page'];
		}else{
			$pageCourante= 1;
		}
		$depart =($pageCourante-1)*$commentaireParPage;

		return array($depart,$commentaireParPage, $commentairesTotaux,$pageCourante);
	}

	public static function addComment($articleId,$auteur,$comment){
		//Permet d'ajouter un commentaire
		$db= self::dbConnect();
		$comments = $db->prepare('INSERT INTO commentaire(id_article, auteur, commentaire ,date_commentaire) VALUES(?,?,?,NOW())');
		$confirmCommentAdd = $comments->execute(array($articleId, $auteur, $comment));

		return $confirmCommentAdd;
		
		
	}

	public static function getCommentSignale($id_commentaire, $id_article){
		//Récupère les commentaire signale
		$db = self::dbConnect();
		$commentSignale = $db->prepare('SELECT signale FROM commentaire WHERE id = ?');
		$commentSignale->execute(array($id_commentaire));

		return $commentSignale;


		
	}

	public static function addCommentSignale($id_commentaire){
		//Permet de signale un commentaire
		$db = self::dbConnect();
		$confirmAddCommentSignale = $db->prepare('UPDATE commentaire SET signale = 0 WHERE id = ?');	
		$confirmAddCommentSignale->execute(array($id_commentaire));

		return $confirmAddCommentSignale;
	}

	public static function addCommentVerif($signale, $id_commentaire){
		//Permet de vérifier un commentaire
		$db = self::dbConnect();
		$confirmVerifComment = $db->prepare('UPDATE commentaire SET signale = ? WHERE id = ?');
		$confirmVerifComment->execute(array($signale ,$id_commentaire));
		
		return $confirmVerifComment;

	}

	public static function supprComment($id_commentaire){
		//Permet de supprimer un commentaire
		$db = self::dbConnect();
		$confirmSupprComment = $db->prepare('DELETE FROM commentaire WHERE id= ?');
		$confirmSupprComment->execute(array($id_commentaire));

		return $confirmSupprComment;
	}
}