<?php 
	session_start();
	$location=$_GET['location'];
	$date = $_GET['date'];
	$serviceType = $_GET['serviceType'];
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$startRegister = false;
	$db_hostname = 'localhost';
	$db_database = 'livies11';
	$db_username = 'root';
	$db_password = 'Buster88';
	$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	try{
		//delete from service request table
		$query = $db->prepare("DELETE from services where userName = ? AND location = ? AND date = ? AND serviceType = ?");	
		$query->execute(array($_SESSION['searchUserName'], $location, $date, $serviceType));
		header("location: searchResultProfile.php");
	}catch(PDOException $ex) {
		echo "An Error occured!"; 
		echo $ex->getMessage();
	}
	
	
?>