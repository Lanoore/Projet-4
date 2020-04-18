<?php
require_once("model/manager.php");

class CommentManager extends Manager{

	public function getComments($postId){
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT id, auteur, commentaire, date_commentaire, signale FROM commentaire WHERE id_article = ? ORDER BY date_commentaire DESC');
		$comments->execute(array($postId));

		return $comments;
	}

	public function addComment($articleId, $auteur, $comment){
		$db= $this->dbConnect();
		$comments = $db->prepare('INSERT INTO commentaire(id_article, auteur, commentaire ,date_commentaire) VALUES(?,?,?,NOW())');
		$confirmCommentAdd = $comments->execute(array($articleId, $auteur, $comment));

		return $confirmCommentAdd;
	}

	public function getCommentSignale($id_commentaire){
		$db = $this->dbConnect();
		$commentSignale = $db->prepare('SELECT signale FROM commentaire WHERE id = ?');
		$commentSignale->execute(array($id_commentaire));

		return $commentSignale;
	}

	public function addCommentSignale($id_commentaire){
		$db = $this->dbConnect();
		$confirmAddCommentSignale = $db->prepare('UPDATE commentaire SET signale = 0 WHERE id = ?');	
		$confirmAddCommentSignale->execute(array($id_commentaire));

		return $confirmAddCommentSignale;
	}
}