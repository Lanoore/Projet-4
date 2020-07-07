<?php



require('model/articleManager.php');
require('model/commentManager.php');
require('model/adminManager.php');


function afficheInfo(){

	require('view/frontend/infoView.php');
}


function afficheListArticles($page){
	$article = new ArticleManager(null);
	$getArticlesNb = $article->getNbArticles();

	$articlesParPage = 8;
	$articlesTotaux = ceil($article->articlesNb/$articlesParPage);

	if(isset($page) AND !empty($page) AND $page> 0 AND $page <=$articlesTotaux){
		$page = intval($page);
		$pageCourante = $page;
	}else{
		$pageCourante = 1;
	}

	$article->depart = ($pageCourante-1)*$articlesParPage;
	$article->articlesParPage = $articlesParPage;
	$articles = $article->getArticles();
	require('view/frontend/listArticleView.php');	
}

function afficheArticle($idArticle,$page){

	if(isset($idArticle)&& $idArticle > 0){
		$article = new ArticleManager($idArticle);
		if(empty($article->id )){
			header('Location:index.php');	
		}
		$comment = new CommentManager($idArticle);
		$commentsNb = $comment->getNbComments();
		
		$commentaireParPage = 5;
		$commentairesTotaux = ceil($comment->commentsNb/$commentaireParPage);

		if(isset($page) AND  !empty($page) AND $page> 0 AND $page <=$commentairesTotaux){
			$page = intval($page);
			$pageCourante = $page;
		}else{
			$pageCourante= 1;
		}
		$depart =($pageCourante-1)*$commentaireParPage;
	
		$comment->depart = $depart;
		$comment->commentaireParPage = $commentaireParPage;
		$comments = $comment->getComments();

	
	
		require('view/frontend/articleView.php');
	}else{
		throw new Exception('Aucun id de billet envoyé');
	}


}

function addComment($articleId){
	if(isset($articleId)&& $articleId > 0){
		if(!empty($_POST['auteur']) && !empty($_POST['commentaire'])){
			if(!preg_match("#[<>1-9]#", $_POST['auteur']) && !preg_match("#[<>]#", $_POST['commentaire'])){
	

				
				$verifArticle = ArticleManager::verifIdArticleExist($articleId);
	
				if(empty($verifArticle)){
					header('Location:index.php');
				}
				else{
					$comment = new CommentManager($articleId);
					$comment->auteur = htmlentities($_POST['auteur']);
					$comment->commentaire = htmlentities($_POST['commentaire']);

					
					$confirmCommentAdd = $comment->addComment();
					if($confirmCommentAdd === false){
						throw new Exception ('Impossible d\'ajouter le commentaire!');
					}
					else{
						header('Location: index.php?action=article&id='.$articleId.'&page=1');
					}
				}
			}
			else{
				throw new Exception('Rentrer un pseudo et un commentaire valide');
			}
		}else{
			throw new Exception('Tous les champs ne sont pas remplis!');
		}
	}else{
		throw new Exception('Aucun identifiant de billet envoyé');
	}
	

	
	

}

function addSignaleCommentaire($id_commentaire, $id_article){

	if(isset($id_commentaire)&& $id_commentaire > 0 && isset($id_article)&& $id_article>0){
		$comment = new CommentManager($id_article);
		$comment->idCommentaire = $id_commentaire;
		$confirmAddSignale = $comment->getCommentSignale();

		if($confirmAddSignale != 0 || $confirmAddSignale != 1){
			$comment->addCommentSignale();
			//CommentManager::addCommentSignale($id_commentaire);
			header('Location: index.php?action=article&id='.$id_article.'&page=1');
		}
		else{
			throw new Exception('Ce commentaire a déjà été signalé');
		}
	}else{
		throw new Exception('Un id de commentaire ainsi qu\'un id d\'article est requis ou est incorrect');
	}

	

}



function accueilAdmin(){
	require('view/frontend/accueilAdminView.php');
}

function connectAdmin(){

	if(!empty($_POST['identifiant']) && !empty($_POST['password'])){
		if(!preg_match("#[<>]#", $_POST['identifiant']) && !preg_match("#[<>]#",$_POST['password'])){
			$adminManager = new GestionAdmin($_POST['identifiant']);
	
			$passwordCorrect  = password_verify($_POST['password'], $adminManager->password);

			if($passwordCorrect){
				header('Location:index.php?action=adminGestionView');
				$_SESSION['identifiant'] = $_POST['identifiant'];
				$_SESSION['id_admin'] = $adminManager->id_admin;
			
			}
			else{
				throw new Exception('Mot de passe ou identifiant invalide');
			}
		}else{
			throw new Exception('Rentrer un identifiant et un mot de passe valide');
		}
	}else{
		throw new Exception('Tous les champs ne sont pas remplis');
	}

	
}


function afficheGestionAdmin(){
		if(isset($_SESSION['identifiant'])){
			$commentsAdmin = GestionAdmin::getCommentsAdmin();


			$articlesAdmin = GestionAdmin::getArticlesAdmin();

			require('view/frontend/adminGestionView.php');
		}
}


function verifComment($id_commentaire){
		if($_SESSION['identifiant']){
			$comment = new CommentManager(null);
			if(isset($_POST['Valider'])){
				$comment->signale = 1;
				$comment->idCommentaire = $id_commentaire;
				$comment->addCommentVerif();
				header('Location: index.php?action=adminGestionView');
			}
			elseif(isset($_POST['Supprimer'])){
				$comment->idCommentaire = $id_commentaire;
				$supprComment = $comment->supprComment();
				if($supprComment == true){
					header('Location: index.php?action=adminGestionView');
				}	
			}
		}
}

function ajoutArticle(){
	if(isset($_SESSION['identifiant'])){
		require('view/frontend/ajoutArticleView.php');
	}
		
}

function addArticle(){
	if(isset($_SESSION['identifiant'])){
		if(!preg_match("#[<>]#", $_POST['titre'])&& !preg_match("#[<>]#", $_POST['description'])){
			

			$article = new articleManager(null);
			$article->titre = $_POST['titre'];
			$article->descr = $_POST['description'];
			$article->texte = $_POST['contenu'];
			$addArticle = $article->addArticle();

			if($addArticle === true){
				header('Location: index.php');
			}
			else{
				throw new Exception('L\'article n\'a pas pu etre envoyer');
			}

		}else{
			throw new Exception('Le titre ou la description n\'est pas valide');
		}
	}
	

}

function modifPassword(){
	if(isset($_SESSION['identifiant'])){
		require('view/frontend/modifPasswordView.php');
	}
	
}

function verifModifPassword(){

	if(isset($_SESSION['identifiant'])){
		if(!preg_match("#[<>]#", $_POST['ancienPassword'])&& !preg_match("#[<>]#",$_POST['nouveauPassword']) && !preg_match("#[<>]#",$_POST['nouveauPasswordVerif'])){
			$adminManager = new GestionAdmin($_SESSION['identifiant']);
	

			if($_POST['nouveauPassword'] == $_POST['nouveauPasswordVerif']){
				$adminManager->password_hache = password_hash($_POST['nouveauPassword'], PASSWORD_DEFAULT);
				
				$passwordCorrect  = password_verify($_POST['ancienPassword'], $adminManager->password);
				if($passwordCorrect){
					$adminManager->identifiant = $_SESSION['identifiant'];
					$modifPassword = $adminManager->modifPassowrd();
					if($modifPassword == true){
						header('Location: index.php?action=adminGestionView');
					}
				}
			}	
		}
	}
	
}
function verifArticle($id_article){
	if(isset($_SESSION['identifiant'])){
		if(isset($_POST['Supprimer'])){
			$adminManager = ArticleManager::supprArticle($id_article);
			if($adminManager === true) {
				header('Location:index.php?action=adminGestionView');
			}	
			else{
				throw new Exception('L\'article n\'a pas pu etre supprimer');
			}
		}
		elseif(isset($_POST['Modifier'])){

			$article = new ArticleManager($id_article);
			

			require('view/frontend/modifArticleView.php');
		}
	}
}

function modifArticle($id_article){
	if(isset($_SESSION['identifiant'])){
		$article = new ArticleManager($id_article);
		$article->titre = htmlentities($_POST['titre']);
		$article->description = htmlentities($_POST['description']);
		$article->texte = htmlentities($_POST['contenu']);
		$adminManager = $article->modifArticle();

		if($adminManager === true){
			header("Location: index.php");
		}
		else{
			throw new Exception('L\'article n\'a pas pu etre modifier');
		}
	}
	
}




