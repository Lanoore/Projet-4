<?php



require('model/articleManager.php');
require('model/commentManager.php');
require('model/adminManager.php');


function afficheListArticles(){
	
	$articlesNb = articleManager::getNbArticles();

	$articles = articleManager::getArticles($articlesNb[0],$articlesNb[1]);

	require('view/frontend/listArticleView.php');	
}

function afficheArticle($idArticle){

	if(isset($idArticle)&& $idArticle > 0){
		$article = new ArticleManager($idArticle);
		if(empty($article->id )){
			header('Location:index.php');	
		}
		$commentsNb = CommentManager::getNbComments($idArticle);
	
		$comments = CommentManager::getComments($idArticle,$commentsNb[0],$commentsNb[1]);
	
	
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
					$confirmCommentAdd = CommentManager::addComment($articleId, $_POST['auteur'], $_POST['commentaire']);
					if($confirmCommentAdd === false){
						throw new Exception ('Impossible d\'ajouter le commentaire!');
					}
					else{
						header('Location: index.php?action=article&id='.$articleId);
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
		$confirmAddSignale = CommentManager::getCommentSignale($id_commentaire, $id_article);
		if($confirmAddSignale != 0 || $confirmAddSignale != 1){
			CommentManager::addCommentSignale($id_commentaire);
			header('Location: index.php?action=article&id='.$id_article);
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
			if(isset($_POST['Valider'])){
				$verifComment = CommentManager::addCommentVerif(1, $id_commentaire);
				header('Location: index.php?action=adminGestionView');
			}
			elseif(isset($_POST['Supprimer'])){
				$supprComment = CommentManager::supprComment($id_commentaire);
				if($supprComment === true){
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
			$addArticle = ArticleManager::addArticle();

			if($addArticle === true){
				header('Location: index.php?action');
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
				$password_hache = password_hash($_POST['nouveauPassword'], PASSWORD_DEFAULT);
				if($_POST['ancienPassowrd'] == $adminManager->password){
		
					$modifPassword = $adminManager->modifPassowrd($password_hache, $_SESSION['identifiant']);
					if($modifPassword == true){
						header('Location: index.php?action=adminGestionView');
					}
				}
				
				
				$passwordCorrect  = password_verify($_POST['ancienPassowrd'], $adminManager->password);
		
				if($passwordCorrect){
					$modifPassword = $adminManager->modifPassowrd($password_hache, $_SESSION['identifiant']);
					if($modifPassword == true){
						header('Location: index.php?action=adminGestionView');
					}	
				}
			}	
		}
	}
	
}
function verifArticle(){
	if(isset($_SESSION['identifiant'])){
		if(isset($_POST['Supprimer'])){
			$adminManager = ArticleManager::supprArticle();
			if($adminManager === true) {
				header('Location:index.php?action=adminGestionView');
			}	
			else{
				throw new Exception('L\'article n\'a pas pu etre supprimer');
			}
		}
		elseif(isset($_POST['Modifier'])){

			$article = new ArticleManager($_GET['id_article']);
			

			require('view/frontend/modifArticleView.php');
		}
	}
}

function modifArticle(){
	if(isset($_SESSION['identifiant'])){
		$adminManager = ArticleManager::modifArticle();
		if($adminManager === true){
			header("Location: index.php?action");
		}
		else{
			throw new Exception('L\'article n\'a pas pu etre modifier');
		}
	}
	
}




