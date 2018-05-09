<?php
	session_start();
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$startRegister = false;
	$db_hostname = 'localhost';
	$db_database = 'livies11';
	$db_username = 'root';
	$db_password = 'Buster88';
	$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$state = $_POST['states'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$company = $_POST['company'];
	
	try{
		$query = $db->prepare("UPDATE registration_login SET email = ?, phone = ?, address = ?, state = ?, city = ?, company = ? WHERE userName = ?");
		$query->execute(array($email, $phone, $address, $state, $city, $company, $_SESSION['userName']));
		$contactMessage = urlencode("Contact edit successfull!");
		
		header('location: edit_client_contact.php?contactMessage='.$contactMessage);
	}catch(PDOException $ex) {
		echo "An Error occured!"; 
		echo $ex->getMessage();
	}
?>