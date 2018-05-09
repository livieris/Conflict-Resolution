<?php
	session_start();
	$_SESSION['userName'];
	$_SESSION['password'];
	$_SESSION['firstName'];
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$startRegister = false;
	$db_hostname = 'localhost';
	$db_database = 'livies11';
	$db_username = 'root';
	$db_password = 'Buster88';
	$db = new PDO("mysql:dbname=" . $db_database . ";host=localhost",$db_username, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
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
			<!-- this is where db will print out persons name  -->
			<div class="section">
				<p>
					<a class="button" href="logOut.php">Log Out</a>
				</p>
				<div class="floatRightText">
					<h2>
					<?php
						echo("Welcome " . $_SESSION['firstName'] . "!");
					?>
					</h2>
				</div>
			</div>
			<br />
			<div id="loginDiv">
				<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$type = $_POST['types'];
					$dateFrom = $_POST['dateFrom'];
					$dateTo = $_POST['dateTo'];
					$location = $_POST['location'];
					if ($dateFrom == "" || $dateTo == "" || $type == "" || $location == ""){
						echo("<div class='floatCenterText'><h3>All fields required</h3></div>");
					}
					else{
						$year = substr($dateFrom, 0, 4);
						$dash1 = substr($dateFrom, 4, 1);
						$month = substr($dateFrom, 5, 2);
						$dash2 = substr($dateFrom, 7, 1);
						$day = substr($dateFrom, 8, 2);
						
						$year2 = substr($dateTo, 0, 4);
						$dash12 = substr($dateTo, 4, 1);
						$month2 = substr($dateTo, 5, 2);
						$dash22 = substr($dateTo, 7, 1);
						$day2 = substr($dateTo, 8, 2);
						
						if ($dash1 == "-" && $dash2 == "-" && is_numeric($year) && is_numeric($month) && is_numeric($day) && $day <= 31 && $month <= 12 &&
							$dash12 == "-" && $dash22 == "-" && is_numeric($year2) && is_numeric($month2) && is_numeric($day2) && $day2 <= 31 && $month2 <= 12){
							$query = $db->prepare("INSERT INTO service_request(id, userName, type, dateFrom, dateTo, location) VALUES ('',?,?,?,?,?)");	
							$query->execute(array($_SESSION['userName'], $type, $dateFrom, $dateTo, $location));
							echo("<div class='floatCenterText'><h3>Service Requested</h3></div>");
						}
						else{
							echo("<div class='floatCenterText'><h3>Date is not in correct format</h3></div>");
						}
					}
				}
				?>
				<h2>Request Services:</h2>
				<form id="contactInfo" action="service_request.php" method = "post">
					<p>
					<label>Type: </label>
				 		<select name = "types">
						 	<option>Training</option>
							<option>Mediation</option>
							<option>Facilitation</option>
							<option>Coaching</option>
							<option>Consultation</option>
						</select>
						<br />
						<br />
						
						<label>Date From: </label>
							<input type="text" name="dateFrom" placeholder="yyyy-mm-dd"><br/><br />
						<label>Date To: </label>
							<input type="text" name="dateTo" placeholder="yyyy-mm-dd"><br/><br />
						<label>Location: </label>
							<input type="text" name="location">
						<br /><br />
						</p>
					<input type="submit" class="button" value="Submit"/><br/>
				</form>
				<div class="floatRightText">
					<p>
						<a class="button" href="profile.php">Back</a>
					</p>
					<br />
				</div>
				
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
</html>