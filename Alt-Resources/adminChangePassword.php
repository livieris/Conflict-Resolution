<?php
session_start();
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
	
	//process change password
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$oldPassword = $_POST['oldPassword'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];
		if($oldPassword == "" || $password == "" || $passwordConfirm == ""){
			$passwordMessage = urlencode("All Fields Required");
			header('location: adminChangePassword.php?passwordMessage='. $passwordMessage);
		}else{
			//encyrpt
			$oldPassword = md5($oldPassword);
			$password = md5($password);
			$passwordConfirm = md5($passwordConfirm);
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
					header('location: adminChangePassword.php?passwordMessage='.$passwordMessage);
				}catch(PDOException $ex) {
					echo "An Error occured!"; 
					echo $ex->getMessage();
				}
			}else{
				if($password!=$passwordConfirm){
					$passwordMessage = urlencode("Password change failed. Password and confirmed passwords don't match. Please try again");
					header('location: adminChangePassword.php?passwordMessage='.$passwordMessage);
				}else{
					$passwordMessage = urlencode("Password change failed. Old password entered wrong. Please try again");
					header('location: adminChangePassword.php?passwordMessage='.$passwordMessage);			
				}
			}
		}
	}else{
	?>
		<!doctype html>
		<html>
			<head>
				<title>Alternative Resolutions, Inc.</title>
				<meta name="robots" content="noindex, nofollow" />
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				<link href ="style.css" type="text/css" rel="stylesheet" />
			</head>
			<body>
				<div id="header">
					<!--<img id="logo" src="images/logoTransparent.png" alt="logo" onclick="http://webdev.cs.uwosh.edu/students/hammod27/individual-phase/index.html">-->
					<h1>Alternative Resolutions, Inc.</h1>
					<p id="navbar">
						<a href="index.html">Home</a>   
						<a href="services.html">Our Services</a>   
						<a href="why.html">Why Our Services Matter</a>   
						<a href="staff_expertise.html">Staff Expertise</a>   
						<a href="previous_clients.html">Previous Clients</a>   
						<a href="professional_articles.html">Professional Articles</a>   
						<a href="portal.php">Portal</a>   
						<a href="contact_us.html">Contact Us</a>
					</p>
				</div>
				<br>
				<br>
				<div id="body">
					<div class="section">
						<h2>Change Password?</h2>
							<div class = "floatCenterText">
							<?php
								if(isset($_GET['passwordMessage'])){
									echo $_GET['passwordMessage'];
									unset($_GET['passwordMessage']);
								}
							?>
							</div>
						
						<form class="contactInfo" method="post">
							<br/>
							<p>
							<label>Old Password:</label>
							<input class = "changePass" type="password" name="oldPassword" placeholder = "Old Password"/><br/>
							</p>
							<p>
							<label>Password:</label>
							<input class="changePass" type="password" name="password" placeholder = "New Password"/><br/>
							</p>
							<p>
							<label>Password: </label>
							<input class="changePass" type="password" name="passwordConfirm" placeholder ="Re-type Password"/>
							</p>
							<br />
							<p>
								<input type="Submit" class="button" value="Submit"/>
							</p>
						</form>
						<div class="floatRightText">
								<p>
									<a class="button" href="profile.php">Back</a>
								</p>					
							<br />
						</div>
					</div>
				</div>
				<div id="footer">
						<p>Disclaimer: This site is under development by UW Oshkosh students as a prototype for the organization of Alternative Resolutions.
							Nothing on the site should be construed in any way as being officially connected with or representative of Alternative
							Resolutions.
						</p>
						<p>
							<a href="http://validator.w3.org/check/referer">
								<img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" width="88" height="64" alt="HTML5 Powered with CSS3 / Styling, and Semantics"
								title="HTML5 Powered with CSS3 / Styling, and Semantics">
							</a>
							<a href="http://jigsaw.w3.org/css-validator/check/referer">
								<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
							</a>
						</p>
					</div>
			</body>
		</html>
	<?php
	}
	?>