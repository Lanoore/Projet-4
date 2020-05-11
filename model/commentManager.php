<?php
require_once("model/manager.php");

class CommentManager extends Manager{

	

	public static function getComments($postId){
		$db = self::dbConnect();
		$comments = $db->prepare('SELECT id, auteur, commentaire, date_commentaire, signale FROM commentaire WHERE id_article = ? ORDER BY date_commentaire DESC');
		$comments->execute(array($postId));

		return $comments;
	}

	public static function addComment($articleId, $auteur, $comment){
		$db= self::dbConnect();
		$comments = $db->prepare('INSERT INTO commentaire(id_article, auteur, commentaire ,date_commentaire) VALUES(?,?,?,NOW())');
		$confirmCommentAdd = $comments->execute(array($articleId, $auteur, $comment));

		if($confirmCommentAdd === false){
			throw new Exception ('Impossible d\'ajouter le commentaire!');
		}
		else{
			header('Location: index.php?action=article&id='.$articleId);
		}
	}

	public static function getCommentSignale($id_commentaire, $id_article){
		$db = self::dbConnect();
		$commentSignale = $db->prepare('SELECT signale FROM commentaire WHERE id = ?');
		$commentSignale->execute(array($id_commentaire));

		if($commentSignale != 0 || $commentSignale != 1){
			self::addCommentSignale($id_commentaire);
			header('Location: index.php?action=article&id='.$id_article);
		}
		else{
			throw new Exception('Ce commentaire a déjà été signalé');
		}
	}

	public static function addCommentSignale($id_commentaire){
		$db = self::dbConnect();
		$confirmAddCommentSignale = $db->prepare('UPDATE commentaire SET signale = 0 WHERE id = ?');	
		$confirmAddCommentSignale->execute(array($id_commentaire));

		return $confirmAddCommentSignale;
	}

	public static function addCommentVerif($signale, $id_commentaire){
		$db = self::dbConnect();
		$confirmVerifComment = $db->prepare('UPDATE commentaire SET signale = ? WHERE id = ?');
		$confirmVerifComment->execute(array($signale ,$id_commentaire));
		
		return $confirmVerifComment;

	}

	public static function supprComment($id_commentaire){
		$db = self::dbConnect();
		$confirmSupprComment = $db->prepare('DELETE FROM commentaire WHERE id= ?');
		$confirmSupprComment->execute(array($id_commentaire));
	}
}