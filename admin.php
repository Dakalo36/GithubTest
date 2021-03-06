<?php 
require ("config.php");
session_start();
$action = isset($_GET['action'])? $_GET['action']: "";
$username = isset($_SESSION['username'])? $_SESSION['username']: "";

if ($action != "login" && $action !="logout" && !$username){
	login();
	exit;
}
switch ($action){
	case 'login':
	login();
	break;
	case 'logout':
	logout();
	break;
	case 'newArticle':
	newArticle();
	break;
	case 'editArticle':
	editArticle();
	break;
	case 'deleteArticle':
	deleteArticle();
	break;
	default:
	listArticle();
}

function login(){
	$results = array();
	$results['pageTitle'] = "Admin login | widget News";
	
	if (isset($_POST['login'])){
		
		if ($_POST['username']==ADMIN_USERNAME && $_POST['password']==ADMIN_PASSWORD){
			$_SESSION['username'] = ADMIN_USERNAME;
			header("Location: admin.php");
		} else{
			//login failled, display an error message
			$results['errorMessage'] = "Incorrect username or password. please try again";
			require (TEMPLATE_PATH. "/admin/loginForm.php");
		}
	}else{
		// if the user has not posted the login form yet: display the form 
		require (TEMPLATE_PATH. "/admin/loginForm.php");
	}
	}
	
	function logout(){
		unset ($_SESSION['username']);
		header("Location: admin.php");
	}
	
	function newArticle(){
		
		$results = array();
		$results['pageTitle'] = "New Article";
		$results['formAction'] = "newArticle";
		
		if(isset($_POST['saveChanges'])){
			
			//user has posted the article edit form: save the new article
			$article = new Article;
			$article->storeFormValues($_POST);
			$article->insert();
			header("Location: admin.php?status=changesSaved");
			
		}elseif (isset($_POST['cancel'])){
			
			//user has cancelled their edits: return to the article list 
			header("Location: admin.php");
		} else {
			// user has not posted the article edit form yet: display the form
			$results['article'] = new Article;
			require (TEMPLATE_PATH. "/admin/editArticle.php");
		}
	}
	
	function editArticle(){
		$results = array();
		$results['pageTitle'] = "Edit Article";
		$results['formAction'] = "editArticle";
		
		if (isset($_POST['saveChanges'])){
			//user has posted the article edit form: save the article changes
			
			if (!$article = Article::getById((int)$_POST['articleId'])){
				header("Location: admin.php?error=articleNotFound"); 
				return; 
			}
			$article->storeFormValues($_POST);
			$article->update();
			header("Location: admin.php?status=changesSaved");
		} elseif (isset($_POST['cancel'])){
			
			header("Location: admin.php");
			
		} else {
			
			$reuslts['article'] = Article::getById((int)$_GET['articleId']);
			require(TEMPLATE_PATH. "/admin/editArticle.php");
			
		}
	}
	
	function deleteArticle(){
		
		if (!$article = Article::getById((int)$_GET['articleId'])){
			header("Location: admin.php?error=articleNotFound");
			return; 
		}
		
		$article->delete();
		header("Location: admin.php?status=articleDeleted");
		
		
	}
	
	function listArticle(){
		$results = array(); 
		$data = Article::getList();
		$results['article'] = $data['results'];
		$results['totalRows'] = $data['totalRows'];
		$results['pageTitle'] = "All Articles";
		
		if (isset($_GET['error'])){
			if($_GET['error'] == "articleNotFound") $results['statusMessage'] = "your changes have been saved.";
			if ($_GET['status'] == "articleDeleted") $results['statusMessage'] = "Article deleted.";
		}
		require (TEMPLATE_PATH. "/admin/listArticles.php");
	}
?>