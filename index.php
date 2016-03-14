<?php 
include_once('Classes/buildDB.php');
		$obj = new buildDB();
		$obj->host = 'localhost';
		$obj->Username = 'root';
		$obj->Password = '';
		$obj->table = 'test';
			$obj->connect();
			
			
			
require ("config.php");
$action = isset($_GET['action']) ?$_GET['action']:"";
switch ($action){
	case 'archive':
		archive();
		break;
	case 'viewArticle':
		viewArticle();
		break;
	default:
		homepage();
}
function archive(){
	$results = array();
	$data = Article::getList();
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Article Archive | widget News";
	require(TEMPLATE_PATH. "/archive.php");
}

function viewArticle(){
	if (!isset ($_GET["articleId"]) || !$_GET["articleId"] ){
		homepage();
		return;
	}
	$results = array();
	$results['article'] = Article::getById ((int)$_GET["articleId"]);
	$results['pageTitle'] = $results['article']->title . "| widget News";
	require(TEMPLATE_PATH. "/viewArticle.php");
}

function homepage(){
	$results = array();
	$data = Article::getList(HOMEPAGE_NUM_ARTICLES);
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "widget News";
	require (TEMPLATE_PATH. "/homepage.php");
}
?>