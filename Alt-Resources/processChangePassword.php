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
	
	$oldPassword = $_POST['oldPassword'];
	$password = $_POST['password'];
	$passwordConfirm = $_POST['passwordConfirm'];
	
	if($oldPassword == "" || $password == "" || $passwordConfirm == ""){
		$passwordMessage = urlencode("All Fields Required");
		header('location: changePassword.php?passwordMessage='. $passwordMessage);
	}else{
		//encyrpt
		$oldPassword = md5($oldPassword);
		$password = md5($password);
		$passwordConfirm = md5($passwordConfirm);
		
		//client/company change own password
		if($_SESSION['permissions']==2 || $_SESSION['permissions']==1){
			//check if old pass is in db for that user and if both new passwords match
			$query = $db->prepare("SELECT password from registration_login WHERE userName = ? AND password = ?");
			$query->execute(array($_SESSION['userName'], $oldPassword));
			$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			if($rows && $password==$passwordConfirm){
				try{
					$query = $db->prepare("UPDATE registration_login SET password = ? WHERE userName = ?");
					$query->execute(array($password, $_SESSION['userName']));
					//displays message of completion
					$passwordMessage = urlencode("Password change successfull!");
					header('location: changePassword.php?passwordMessage='.$passwordMessage);
				}catch(PDOException $ex) {
					echo "An Error occured!"; 
					echo $ex->getMessage();
				}
			}else{
				if($password!=$passwordConfirm){
					$passwordMessage = urlencode("Password change failed. Password and confirmed passwords don't match. Please try again");
					header('location: changePassword.php?passwordMessage='.$passwordMessage);
				}else{
					$passwordMessage = urlencode("Password change failed. Old password entered wrong. Please try again");
					header('location: changePassword.php?passwordMessage='.$passwordMessage);			
				}
			}
		//staff change users/company password
		}else{
				try{
					$query = $db->prepare("UPDATE registration_login SET password = ? WHERE userName = ?");
					$query->execute(array($password, $_SESSION['searchUserName']));
					//displays message of completion
					$passwordMessage = urlencode("Password change successfull!");
					header('location: changePassword.php?passwordMessage='.$passwordMessage);
				}catch(PDOException $ex) {
					echo "An Error occured!"; 
					echo $ex->getMessage();
				}
		}
	}
?>