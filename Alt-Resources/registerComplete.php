<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$startRegister = false;
	$db_hostname = 'localhost';
	$db_database = 'livies11';
	$db_username = 'root';
	$db_password = 'Buster88';
	$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$password = md5($password);
	$passwordConfirm = $_POST["passwordConfirm"];
	$passwordConfirm = md5($passwordConfirm);
	$address = $_POST["address"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$emailConfirm = $_POST["emailConfirm"];
	$company = $_POST["company"];
	$clientNotes = $_POST["cNotes"];
	$lastName=$_POST["lastName"];
	$firstName=$_POST["firstName"];
	$state=$_POST["state"];
	$city=$_POST["city"];
			//if password equal... encrypt password
			//$password=encypt($password);
	if ($userName == "" || $password == "" || $passwordConfirm == "" || $address == "" || $phone == "" || $email == "" || 
		$emailConfirm == "" || $lastName == "" || $firstName == "" || $state == "" || $city == ""){
			$failMesage = urlencode("All fields except Client Notes are required");
			header("location: register.php?failMessage=".$failMesage);
		}
	else if (strpos($userName,' ') !== false){
		$failMesage = urlencode("Username cannot contain a space.");
			header("location: register.php?failMessage=".$failMesage);
	}
	else{
			
	try{
		//checks for user name in db
		$query = $db->prepare("SELECT userName FROM registration_login WHERE userName = ?");
		$query->execute(array($userName));
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);
		$rowCount=$query->rowCount();
		//if not in db create user
		if($rowCount!=1){
			$query = $db->prepare("INSERT into registration_login (userName, lastName, firstName, password, email, phone, address, state, city, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$query->execute(array($userName, $lastName, $firstName, $password, $email, $phone, $address, $state, $city, $company));
			$query = $db->prepare("INSERT into notes (userName, clientNote) VALUES (?, ?)");
			$query->execute(array($userName, $clientNotes));
			$query = $db->prepare("INSERT into permissions (userName, client) VALUES (?, 'y')");
			$query->execute(array($userName));
			
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
							<a href="portal.html">Portal</a>   
							<a href="contact_us.html">Contact Us</a>
						</p>
					</div>
					<br>
					<br>
					<div id="body">
						<div id="loginDiv">
							<h2>Registration Complete!</h2>
						</div>
						<br /> <br />
						<div class = "section">
							<a class = "button" href="portal.php">Login?</a>
						</div>
					</div>
					<br/>
					<div id="footer">
						<p>Disclaimer: This site is under development by UW Oshkosh students as a prototype for the organization of Alternative Resolutions.
							Nothing on the site should be construed in any way as being officially connected with or representative of Alternative Resolutions.
						</p>
						<p>
						<a href="http://validator.w3.org/check/referer">
						<img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png"
						width="88" height="64"
						alt="HTML5 Powered with CSS3 / Styling, and Semantics"
						title="HTML5 Powered with CSS3 / Styling, and Semantics">
						</a>
						<a href="http://jigsaw.w3.org/css-validator/check/referer">
						<img style="border:0;width:88px;height:31px"
						src="http://jigsaw.w3.org/css-validator/images/vcss"
						alt="Valid CSS!" />
						</a>
						</p>
					</div>
				</body>
		<?php
		}else{
			header("location: index.html");
		}
	}catch(PDOException $ex) {
		echo "An Error occured!"; 
		echo $ex->getMessage();
	}//else not equal, failed message
	}
	?>
</html>